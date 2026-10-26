<?php
/**
 * "Avvisi in Home" helpers for the homepage hero "In evidenza" panel.
 *
 * Kept outside the upstream templates so merges from Design Scuole Italia
 * stay small: the option fields live in inc/admin/options.php (home_messages
 * tab), the resolution of defaults lives here, and the templates only print
 * the already-resolved values.
 *
 * An avviso can point to a post (articolo or evento). Every field left empty
 * in the avviso is taken from that post:
 *   titolo       testo_message        -> post title
 *   sottotitolo  sottotitolo_message  -> evento/articolo descrizione -> excerpt
 *   url          link_message         -> permalink
 *   scadenza     data_message         -> evento end -> post date + 30 days
 */

if ( ! function_exists( 'marconi_avvisi_post_options' ) ) {
	/**
	 * Options for the "Contenuto collegato" select: recent articles and
	 * current/future events, plus the currently saved value.
	 */
	function marconi_avvisi_post_options( $field = null ) {
		$options = array();

		$posts = get_posts( array(
			'post_type'        => array( 'post', 'evento' ),
			'post_status'      => 'publish',
			'posts_per_page'   => 150,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'date_query'       => array( array( 'after' => '1 year ago' ) ),
			'suppress_filters' => true,
		) );

		if ( $field && is_object( $field ) && method_exists( $field, 'escaped_value' ) ) {
			$current = absint( $field->escaped_value() );
			if ( $current && ! in_array( $current, wp_list_pluck( $posts, 'ID' ), true ) ) {
				$current_post = get_post( $current );
				if ( $current_post ) {
					$posts[] = $current_post;
				}
			}
		}

		foreach ( $posts as $post ) {
			$type = 'evento' === $post->post_type ? __( 'Evento', 'design_scuole_italia' ) : __( 'Articolo', 'design_scuole_italia' );
			$options[ $post->ID ] = sprintf( '[%s %s] %s', $type, get_the_date( 'd/m/Y', $post ), get_the_title( $post ) );
		}

		return $options;
	}
}

if ( ! function_exists( 'marconi_avvisi_icon_options' ) ) {
	/**
	 * Options for the "Icona" select, from the shared Marconi icon set.
	 */
	function marconi_avvisi_icon_options() {
		$keys = array_keys( marconi_servizio_icon_paths() );
		return array_combine( $keys, $keys );
	}
}

if ( ! function_exists( 'marconi_avviso_end_of_day' ) ) {
	/**
	 * Timestamp of 23:59:59 (site timezone) of a 'Y-m-d' date, 0 if invalid.
	 */
	function marconi_avviso_end_of_day( $ymd ) {
		$end = $ymd ? date_create_immutable_from_format( 'Y-m-d H:i:s', $ymd . ' 23:59:59', wp_timezone() ) : false;
		return $end ? $end->getTimestamp() : 0;
	}
}

if ( ! function_exists( 'marconi_get_avviso' ) ) {
	/**
	 * Resolve one "Avvisi in Home" entry, filling empty fields from the
	 * linked post.
	 *
	 * @param array $avviso Raw group entry from the home_messages option.
	 * @return array {
	 *     @type string $titolo
	 *     @type string $sottotitolo
	 *     @type string $url
	 *     @type string $tipo               'evento' | 'articolo' | 'link'
	 *     @type int    $data_inizio        Event start timestamp (eventi only).
	 *     @type int    $data_pubblicazione Post date timestamp (articoli only).
	 *     @type string $categoria          First category name.
	 *     @type string $icona              Key of marconi_servizio_icon_paths().
	 *     @type string $colore             Original colore_message value.
 *     @type bool   $mostra_icona       "Visualizza icona": icon instead of the event date.
	 *     @type int    $scadenza           Expiry timestamp, 0 = never.
	 * }
	 */
	function marconi_get_avviso( $avviso ) {
		$avviso  = is_array( $avviso ) ? $avviso : array();
		$post_id = isset( $avviso['post_message'] ) ? absint( $avviso['post_message'] ) : 0;
		$post    = $post_id ? get_post( $post_id ) : null;
		if ( $post && 'publish' !== $post->post_status ) {
			$post = null;
		}

		$field = function ( $key ) use ( $avviso ) {
			return isset( $avviso[ $key ] ) && is_string( $avviso[ $key ] ) ? trim( $avviso[ $key ] ) : '';
		};

		$resolved = array(
			'titolo'             => $field( 'testo_message' ),
			'sottotitolo'        => $field( 'sottotitolo_message' ),
			'url'                => $field( 'link_message' ),
			'tipo'               => 'link',
			'data_inizio'        => 0,
			'data_pubblicazione' => 0,
			'categoria'          => '',
			'icona'              => $field( 'icona_evidenza' ),
			'colore'             => $field( 'colore_message' ),
			'mostra_icona'       => ! empty( $avviso['icona_message'] ),
			'scadenza'           => 0,
		);

		$data_fine = $field( 'data_message' );
		if ( '' !== $data_fine ) {
			$parsed = date_create_immutable_from_format( '!d-m-Y', $data_fine );
			$resolved['scadenza'] = $parsed ? marconi_avviso_end_of_day( $parsed->format( 'Y-m-d' ) ) : 0;
		}

		if ( $post ) {
			$is_evento        = 'evento' === $post->post_type;
			$resolved['tipo'] = $is_evento ? 'evento' : 'articolo';

			if ( '' === $resolved['titolo'] ) {
				$resolved['titolo'] = get_the_title( $post );
			}
			if ( '' === $resolved['url'] ) {
				$resolved['url'] = get_permalink( $post );
			}
			if ( '' === $resolved['sottotitolo'] ) {
				$meta_key    = $is_evento ? '_dsi_evento_descrizione' : '_dsi_articolo_descrizione';
				$descrizione = trim( wp_strip_all_tags( (string) get_post_meta( $post->ID, $meta_key, true ) ) );
				if ( '' === $descrizione ) {
					$descrizione = trim( wp_strip_all_tags( get_the_excerpt( $post ) ) );
				}
				$resolved['sottotitolo'] = wp_trim_words( $descrizione, 12, '…' );
			}

			$terms = get_the_terms( $post, 'category' );
			if ( empty( $terms ) || is_wp_error( $terms ) ) {
				$terms = get_the_terms( $post, 'tipologia-articolo' );
			}
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				$resolved['categoria'] = $terms[0]->name;
			}

			if ( $is_evento ) {
				$inizio = (int) get_post_meta( $post->ID, '_dsi_evento_timestamp_inizio', true );
				$fine   = (int) get_post_meta( $post->ID, '_dsi_evento_timestamp_fine', true );
				$resolved['data_inizio'] = $inizio;
				// CMB2 text_date_timestamp: the theme prints these with date_i18n(), i.e. as UTC.
				$ultimo = $fine ? $fine : $inizio;
				if ( ! $resolved['scadenza'] && $ultimo ) {
					$resolved['scadenza'] = marconi_avviso_end_of_day( gmdate( 'Y-m-d', $ultimo ) );
				}
			} else {
				$resolved['data_pubblicazione'] = (int) get_post_time( 'U', true, $post );
				if ( ! $resolved['scadenza'] ) {
					$resolved['scadenza'] = marconi_avviso_end_of_day( wp_date( 'Y-m-d', $resolved['data_pubblicazione'] + 30 * DAY_IN_SECONDS ) );
				}
			}

			if ( '' === $resolved['icona'] ) {
				$term_slug          = ! empty( $terms ) && ! is_wp_error( $terms ) ? $terms[0]->slug : '';
				$resolved['icona']  = apply_filters( 'marconi_avviso_icona', 'it-note', $term_slug, $post );
			}
		}

		if ( '' === $resolved['icona'] || ! array_key_exists( $resolved['icona'], marconi_servizio_icon_paths() ) ) {
			$resolved['icona'] = 'it-note';
		}

		return apply_filters( 'marconi_get_avviso', $resolved, $avviso, $post );
	}
}

if ( ! function_exists( 'marconi_avviso_posizione' ) ) {
	function marconi_avviso_posizione( $avviso ) {
		return is_array( $avviso ) && isset( $avviso['posizione_message'] ) && 'evidenza' === $avviso['posizione_message'] ? 'evidenza' : 'barra';
	}
}

if ( ! function_exists( 'marconi_get_avvisi' ) ) {
	/**
	 * Active, resolved avvisi for one position.
	 *
	 * @param string $posizione 'evidenza' (hero panel, max 3) or 'barra'.
	 * @return array List of marconi_get_avviso() results.
	 */
	function marconi_get_avvisi( $posizione = 'evidenza' ) {
		$messages = dsi_get_option( 'messages', 'home_messages' );
		if ( empty( $messages ) || ! is_array( $messages ) ) {
			return array();
		}

		$now    = time();
		$avvisi = array();
		foreach ( $messages as $message ) {
			if ( marconi_avviso_posizione( $message ) !== $posizione ) {
				continue;
			}
			$avviso = marconi_get_avviso( $message );
			if ( '' === $avviso['titolo'] || '' === $avviso['url'] ) {
				continue;
			}
			if ( $avviso['scadenza'] && $avviso['scadenza'] < $now ) {
				continue;
			}
			$avvisi[] = $avviso;
		}

		return 'evidenza' === $posizione ? array_slice( $avvisi, 0, 3 ) : $avvisi;
	}
}

/*
 * Expired avvisi are hidden at render time (template-parts/home/messages.php,
 * marconi_get_avvisi()), never deleted. The upstream daily cron
 * dsi_check_cron_options() (inc/admin/options.php) deleted them instead, and
 * it also removed every message with an empty "Data fine" (strtotime('') is
 * false, and false <= now) and rewrote home_messages with the messages only,
 * dropping the "In evidenza" panel fields.
 */
add_action( 'init', function () {
	remove_action( 'dsi_cron_options', 'dsi_check_cron_options' );
} );
