# AGENTS.md

## Purpose

This repository is a customized fork of `design-scuole-wordpress-theme` for ITTM Marconi.
It is a WordPress theme inside `wp-content/themes/design-scuole-wordpress-theme`.
Agents should optimize for safe, minimal, convention-matching edits.

## Project Shape

- Core theme bootstrap lives in `functions.php`.
- Most PHP behavior is split across `inc/*.php`.
- Content-type configuration lives in `inc/admin/*.php`.
- Reusable frontend fragments live in `template-parts/`.
- Full page templates live in `page-templates/`.
- Menu walkers live in `walkers/`.
- Custom source CSS lives in `assets-src/css/`.
- Built/minified CSS output lives in `assets/css/`.
- Theme JS is edited directly in `assets/js/`.
- Vendor code lives in `inc/vendor/` and `assets/js/components/`.

## Instruction Sources

- `CLAUDE.md` exists and should be treated as active repository guidance.
- No `.cursorrules` file was found.
- No `.cursor/rules/` directory was found.
- No `.github/copilot-instructions.md` file was found.
- No existing root `AGENTS.md` was present when this file was created.

## High-Value Rules

- Preserve the WordPress theme architecture; do not introduce framework-style abstractions unless already present nearby.
- Prefer small, local edits over large refactors.
- Do not edit vendor code unless the user explicitly asks.
- Do not edit compiled assets in `assets/css/` by hand.
- After changing source CSS, rebuild CSS output.
- Gutenberg is intentionally disabled; do not add block-editor-dependent features.
- Respect Bootstrap Italia markup patterns already used by the theme.
- For Marconi-specific additions, prefer the `marconi_` or `ittm_` prefix.

## Build Commands

Run commands from the theme root.

```bash
npm install
composer install
```

- `npm run build` - full production asset build.
- `npm run build:css` - rebuild all CSS from `assets-src/css/` into `assets/css/`.
- `npm run minify:css` - minify non-Tailwind CSS only.
- `npm run tail:build` - compile minified Tailwind CSS.
- `npm run tail:watch` - watch Tailwind CSS during development.
- `npm run minify:js` - minify JS assets handled by the Node script.
- `npm run import:md` - run the Markdown import utility.

## Lint / Validation Commands

There is no first-party repo-wide lint script configured in `package.json` or `composer.json`.
Use the lightest relevant validation for the files you touched.

```bash
php -l path/to/file.php
node --check path/to/file.js
npx tailwindcss -i ./assets-src/css/tail.css -o ./assets/css/tail.css --minify
```

Useful targeted checks:

- `php -l functions.php` - syntax-check a PHP file.
- `php -l inc/rest-api.php` - syntax-check modern typed PHP.
- `node --check assets/js/marconi/marconi.js` - syntax-check theme JS.
- `npm run build:css` - validate CSS/Tailwind build after CSS edits.
- `npm run build` - best end-to-end asset verification available in-repo.

## Test Commands

There is no supported first-party automated test suite for the Marconi theme itself.
No root `phpunit.xml`, Jest, Vitest, Cypress, or Playwright config was found.

What exists:

- Vendor PHPUnit configs under `inc/vendor/`.
- Vendor tests for bundled libraries such as CMB2 and dompdf.

For normal theme work, prefer:

- syntax checks for changed PHP/JS files,
- `npm run build` or `npm run build:css`,
- manual verification in a local WordPress instance.

## Running A Single Test

There is no project-level single-test command for theme code because there is no project-level test suite.

If you intentionally need to run a vendor test, do it explicitly against that vendor package and mention in your report that it does **not** validate the whole theme.

Examples:

```bash
phpunit --configuration inc/vendor/CMB2/phpunit.xml.dist inc/vendor/CMB2/tests/test-cmb-utils.php
phpunit --configuration inc/vendor/dompdf/lib/php-svg-lib/phpunit.xml inc/vendor/dompdf/lib/php-svg-lib/tests/Svg/StyleTest.php
```

Only run vendor tests when you are changing that vendor area or the user explicitly requests it.

## Local Runtime

- The theme is expected to run inside a WordPress installation.
- `Docker.md` documents a WordPress + MariaDB local setup.
- Start the stack from a parent directory containing `wp-content/`.
- A realistic manual test requires WordPress, the theme, and relevant plugins.

## Files You Usually Should Edit

- `functions.php` for bootstrapping and enqueue wiring.
- `inc/*.php` for hooks, utilities, REST behavior, and setup logic.
- `inc/admin/*.php` for custom post type field definitions.
- `template-parts/**/*.php` for reusable frontend markup.
- `page-templates/*.php` for page-level composition.
- `assets-src/css/*.css` for source styles.
- `assets/js/marconi/marconi.js` or `assets/js/scuole.js` for theme JS.

## Files You Usually Should Not Edit

- `assets/css/*` directly; these are generated outputs.
- `inc/vendor/**` unless explicitly requested.
- `assets/js/components/**` unless explicitly requested.
- auto-generated or minified vendor files when source files exist elsewhere.

## Code Style: PHP

- Match existing WordPress style in legacy files.
- Use tabs/spacing consistent with the file you are editing; many PHP files use WordPress-style tab indentation.
- Keep braces and control structures aligned with nearby code.
- Prefer single quotes unless interpolation or escaping makes double quotes clearer.
- Use associative arrays in WordPress style: `array(...)` in legacy files, short arrays `[]` only where the surrounding file already uses them.
- When editing modern typed files like `inc/rest-api.php`, preserve typed parameters and return types.
- Do not force `declare(strict_types=1);`; it is not established in this codebase.

## Imports / Includes

- PHP does not use a broad import system here.
- Bootstrap files are loaded with `require get_template_directory() . '/path.php';`.
- If adding a new bootstrap include, keep it in `functions.php` with the existing grouped structure.
- Composer PSR-4 autoload exists for `src/`, but `src/` is not currently used by the main theme flow.

## Naming Conventions

- Use `dsi_` for upstream-style theme functions.
- Use `marconi_` for Marconi-specific customizations.
- Use `ittm_` for ITTM-specific integrations such as REST import helpers.
- Keep WordPress hooks, meta keys, taxonomy keys, and option names aligned with existing prefixes.
- Use snake_case for PHP function names and meta keys.
- Keep template filenames lowercase with hyphens or underscores matching nearby files.

## Types And Data Handling

- Legacy PHP is mostly dynamic; match the local style instead of over-typing old files.
- In new isolated logic, scalar type hints and union returns are acceptable if the surrounding file already uses modern PHP.
- Cast request data deliberately.
- Sanitize all `$_GET`, `$_POST`, and REST input before use.
- Expect common WordPress APIs to return `false`, empty arrays, or `WP_Error`.

## Escaping, Security, And Error Handling

- Escape output late with the appropriate WordPress function: `esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`.
- Sanitize input early with helpers such as `sanitize_text_field`, `sanitize_key`, `absint`.
- Use nonces for privileged actions and verify them before mutating data.
- For REST endpoints, prefer capability checks plus `WP_Error` responses on failure.
- Check `is_wp_error()` when calling APIs that may fail.
- Avoid raw SQL unless necessary; if using `$wpdb`, prepare values properly.

## Templates And Frontend

- Prefer reusing existing `template-parts/` before creating new top-level templates.
- Preserve Bootstrap Italia class structure unless intentionally redesigning a component.
- When refactoring CSS-related UI, prefer Tailwind utility classes where practical, per `CLAUDE.md`.
- Only add custom CSS to `assets-src/css/scuole-marconi.css` when utilities are insufficient.
- Keep pages working on desktop and mobile.

## JavaScript Style

- Theme JS is currently simple, mostly jQuery-based, and globally scoped.
- Match the surrounding file style rather than introducing bundlers or modules.
- Avoid modern build assumptions for frontend JS unless the file already uses them.
- Keep selectors specific and event handlers easy to trace.
- After JS edits, run `node --check` on changed files and, when relevant, `npm run minify:js`.

## CSS Style

- Edit source files in `assets-src/css/` only.
- Rebuild CSS after any source CSS change.
- Keep custom properties and color tokens in sync with the existing theme vocabulary.
- Preserve accessibility, especially contrast-sensitive color choices already documented in CSS comments.
- Prefer incremental changes over broad stylesheet rewrites.

## Manual Verification Checklist

- Open the affected template/page in a local WordPress instance.
- Confirm no PHP syntax errors.
- Confirm assets rebuild successfully if CSS changed.
- Confirm markup still matches Bootstrap Italia expectations.
- Confirm user-facing strings remain localized and escaped.
- Confirm no accidental edits to generated assets or vendor code.

## Agent Workflow

- Read nearby files before editing to match local conventions.
- Mention when a command is unavailable because the repo does not define it.
- If you add CSS source changes, say that `npm run build:css` is required or run it yourself.
- If no automated tests apply, say so clearly and list the exact validation you performed.
