<?php
/**
 * REST API extensions for Markdown batch import.
 *
 * Three responsibilities:
 *  A. Enable show_in_rest on the CPTs used by the importer.
 *  B. Register specific CMB2 meta keys as REST-writable.
 *  C. Custom endpoint POST /wp-json/ittm/v1/set-terms to bypass
 *     non-standard taxonomy capability checks.
 *
 * @package Design_Scuole_Italia
 */

// ─── Allow Application Passwords over HTTP for loopback requests ─────────────
// WordPress 5.6+ requires HTTPS for Application Passwords. When the import
// script runs on the same server and connects via http://localhost, the
// Authorization header is silently ignored. This filter re-enables Application
// Passwords for loopback (127.0.0.1 / ::1) connections only.

add_filter( 'wp_is_application_passwords_available', 'ittm_allow_app_passwords_on_loopback' );
function ittm_allow_app_passwords_on_loopback( bool $available ): bool {
	$remote = $_SERVER['REMOTE_ADDR'] ?? '';
	if ( in_array( $remote, [ '127.0.0.1', '::1' ], true ) ) {
		return true;
	}
	return $available;
}

// ─── A: Enable show_in_rest on CPTs ─────────────────────────────────────────

add_filter( 'register_post_type_args', 'ittm_enable_rest_for_import_cpts', 10, 2 );
function ittm_enable_rest_for_import_cpts( array $args, string $post_type ): array {
	$enabled = [
		'post', 'circolare', 'scheda_progetto', 'scheda_didattica',
		'documento', 'evento', 'servizio', 'struttura', 'luogo',
	];
	if ( in_array( $post_type, $enabled, true ) ) {
		$args['show_in_rest'] = true;
	}
	return $args;
}

// ─── B: Register meta keys as REST-writable ──────────────────────────────────

add_action( 'init', 'ittm_register_import_meta' );
function ittm_register_import_meta(): void {
	$auth = static function (): bool {
		return current_user_can( 'edit_posts' );
	};

	$base = [
		'single'       => true,
		'show_in_rest' => true,
		'auth_callback' => $auth,
	];

	$string = array_merge( $base, [ 'type' => 'string' ] );
	$bool   = array_merge( $base, [ 'type' => 'boolean' ] );

	// post (articolo)
	register_post_meta( 'post', '_dsi_articolo_descrizione', $string );

	// circolare
	register_post_meta( 'circolare', '_dsi_circolare_descrizione',               $string );
	register_post_meta( 'circolare', '_dsi_circolare_numerazione_circolare',      $string );
	register_post_meta( 'circolare', '_dsi_circolare_is_pubblica',                $bool );

	// scheda_progetto
	register_post_meta( 'scheda_progetto', '_dsi_scheda_progetto_descrizione',    $string );
	register_post_meta( 'scheda_progetto', '_dsi_scheda_progetto_obiettivi',      $string );
	register_post_meta( 'scheda_progetto', '_dsi_scheda_progetto_timestamp_inizio', $string );
	register_post_meta( 'scheda_progetto', '_dsi_scheda_progetto_timestamp_fine',   $string );

	// scheda_didattica
	register_post_meta( 'scheda_didattica', '_dsi_scheda_didattica_descrizione',  $string );

	// documento
	register_post_meta( 'documento', '_dsi_documento_descrizione',               $string );
	register_post_meta( 'documento', '_dsi_documento_data_scadenza',             $string );
}

// ─── C: Custom endpoint /ittm/v1/set-terms ───────────────────────────────────

add_action( 'rest_api_init', 'ittm_register_set_terms_endpoint' );
function ittm_register_set_terms_endpoint(): void {
	register_rest_route(
		'ittm/v1',
		'/set-terms',
		[
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => 'ittm_rest_set_terms',
			'permission_callback' => static function (): bool {
				return current_user_can( 'edit_posts' );
			},
			'args' => [
				'post_id'  => [
					'required'          => true,
					'type'              => 'integer',
					'sanitize_callback' => 'absint',
				],
				'taxonomy' => [
					'required'          => true,
					'type'              => 'string',
					'sanitize_callback' => 'sanitize_key',
				],
				'terms'    => [
					'required' => true,
					'type'     => 'array',
					'items'    => [ 'type' => 'string' ],
				],
			],
		]
	);
}

function ittm_rest_set_terms( WP_REST_Request $request ): WP_REST_Response|WP_Error {
	$post_id  = $request->get_param( 'post_id' );
	$taxonomy = $request->get_param( 'taxonomy' );
	$terms    = (array) $request->get_param( 'terms' );

	if ( ! taxonomy_exists( $taxonomy ) ) {
		return new WP_Error(
			'invalid_taxonomy',
			sprintf( 'Taxonomy "%s" does not exist.', $taxonomy ),
			[ 'status' => 400 ]
		);
	}

	if ( ! get_post( $post_id ) ) {
		return new WP_Error(
			'invalid_post',
			sprintf( 'Post %d does not exist.', $post_id ),
			[ 'status' => 404 ]
		);
	}

	$term_ids = [];
	foreach ( $terms as $term_name ) {
		$term_name = sanitize_text_field( (string) $term_name );
		if ( $term_name === '' ) {
			continue;
		}

		// Try by slug first, then by name.
		$term = get_term_by( 'slug', $term_name, $taxonomy );
		if ( ! $term ) {
			$term = get_term_by( 'name', $term_name, $taxonomy );
		}

		if ( ! $term ) {
			// Create the term if it doesn't exist.
			$inserted = wp_insert_term( $term_name, $taxonomy );
			if ( is_wp_error( $inserted ) ) {
				return new WP_Error(
					'term_creation_failed',
					sprintf( 'Could not create term "%s": %s', $term_name, $inserted->get_error_message() ),
					[ 'status' => 500 ]
				);
			}
			$term_ids[] = $inserted['term_id'];
		} else {
			$term_ids[] = $term->term_id;
		}
	}

	// wp_set_object_terms bypasses capability checks — that is intentional here.
	$result = wp_set_object_terms( $post_id, $term_ids, $taxonomy );
	if ( is_wp_error( $result ) ) {
		return new WP_Error(
			'set_terms_failed',
			$result->get_error_message(),
			[ 'status' => 500 ]
		);
	}

	return new WP_REST_Response( [ 'set' => $result ], 200 );
}
