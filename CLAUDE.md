# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a **fork** of the official Italian government WordPress theme "Design Scuole Italia" (v2.5.1), customized for **ITTM - Istituto Tecnico Tecnologico Marconi**. The upstream project is at https://github.com/italia/design-scuole-wordpress-theme. It lives inside a WordPress installation at `wp-content/themes/design-scuole-wordpress-theme/`.

The theme implements the [Italian government school website model](https://designers.italia.it/modelli/scuole/) and uses [Bootstrap Italia](https://italia.github.io/bootstrap-italia/) as its design system. The Gutenberg block editor is intentionally disabled — the theme requires the **Disable Gutenberg** plugin.

## Build Commands

```bash
# Install dependencies
npm install

# Full production build (minify CSS + JS + Tailwind)
npm run build

# Build all CSS in one shot: minify CSS + compile Tailwind (use this after editing any source CSS)
npm run build:css

# Minify only CSS (assets-src/css/ → assets/css/, excludes tail.css)
npm run minify:css

# Compile Tailwind only, minified one-shot (assets-src/css/tail.css → assets/css/tail.css)
npm run tail:build

# Watch Tailwind for changes during development
npm run tail:watch

# Minify only JS
npm run minify:js
```

**Important**: Always edit files in `assets-src/css/`, **never directly in `assets/css/`**. The `assets/` directory contains compiled/minified output that is overwritten on every build. After editing any source CSS, run `npm run build:css` — this rebuilds both the minified CSS files and `tail.css` in parallel. There is no `assets-src/js/` directory — `assets/js/marconi/marconi.js` and `assets/js/scuole.js` are edited directly.

## Docker Development

See [Docker.md](Docker.md) for a full `docker-compose.yml` setup (WordPress + MariaDB). The theme folder is volume-mounted into the container. Start with `docker-compose up` from a parent directory containing the `wp-content/` folder.

## Architecture

### PHP Entry Point

`functions.php` bootstraps everything by requiring files from `inc/`:

| File | Purpose |
|------|---------|
| `inc/define.php` | Global constants (Mapbox token) |
| `inc/vocabolario.php` | Italian school type taxonomy data |
| `inc/cmb2.php` + `inc/backend-template.php` | CMB2 custom fields framework |
| `inc/admin/*.php` | CMB2 field definitions per content type |
| `inc/actions.php` | WordPress hooks and filters |
| `inc/activation.php` | Theme activation hooks |
| `inc/utils.php` | Shared utility functions |
| `inc/notification.php` | Circular notification system |
| `inc/breadcrumb.php` | Breadcrumb class |
| `inc/import.php` | Content migration/import logic |
| `inc/dompdf.php` | PDF generation via dompdf |
| `inc/theme-dependencies.php` | Required plugin list (TGM Plugin Activation) |
| `walkers/` | `WP_Walker` subclasses for header/footer/mobile menus |

### Custom Post Types

The theme registers these content types (defined in `inc/admin/*.php` via CMB2):

- `struttura` — organizational structures (offices, departments, etc.)
- `luogo` — physical locations with maps
- `servizio` — school services
- `indirizzo` — study programs/courses
- `evento` — calendar events
- `documento` — documents (includes *albo online* and *amministrazione trasparente*)
- `circolare` — official circulars with notification workflow
- `scheda_didattica` — teacher-authored educational content
- `scheda_progetto` — school projects
- `materia` / `programma_materia` — subjects and subject programs
- Native `post` — news (tipologia: *news* or *articoli*)

### Template Hierarchy

- `template-parts/` — reusable partials, organized by content type (e.g., `template-parts/servizio/`, `template-parts/struttura/`)
- `page-templates/` — full-page templates assigned via WP admin (e.g., `la-scuola.php`, `didattica.php`, `notizie.php`)
- Root-level `single-*.php` and `archive-*.php` files — standard WP template files per CPT

### CSS Refactoring Strategy

When refactoring or rewriting CSS — whether fixing layout bugs, simplifying overrides, or touching existing rules — **prefer Tailwind utility classes over new custom CSS** whenever practical. Add utilities directly to the PHP/HTML template and remove the corresponding custom rules from `scuole-marconi.css`. New standalone components should be written in Tailwind from the start. Only write custom CSS in `scuole-marconi.css` when a Tailwind utility genuinely cannot express the intent (e.g. complex selectors, pseudo-elements, vendor-specific rules, or Bootstrap Italia overrides that require specificity). Run `npm run build:css` after any change to either source file.

### CSS Architecture

| File | Description |
|------|-------------|
| `assets-src/css/scuole-marconi.css` | **Primary custom CSS** for Marconi school (replaces upstream `scuole.css`) |
| `assets-src/css/overrides.css` | Bootstrap Italia overrides |
| `assets-src/css/admin-style.css` | WP admin interface styles |
| `assets-src/css/tail.css` | TailwindCSS source (processed by `npm run tail`) |
| `assets/css/bootstrap-italia.css` | Vendor — do not modify |
| `assets/css/fonts.css` | Vendor font definitions |

### Marconi-Specific Customizations

The fork introduces these local customizations on top of the upstream theme:

1. **`scuole-marconi.css`** is loaded instead of `scuole.css`
2. **`assets/js/marconi/marconi.js`** — custom JS, loaded via `marconi_scripts()` in `functions.php`
3. **`wpautop_icons()`** in `functions.php` — converts prefixed contact text (`mail:`, `pec:`, `tel:`, `fax:`, `map:`) into icon+link HTML
4. **`breadcrumb_fix()`** filter — rewrites certain breadcrumb labels for the school's preferred naming
5. `admin_theme_style()` is enqueued on both frontend and admin (unlike upstream)

### PHP Function Prefix

All theme functions use the `dsi_` prefix (Design Scuole Italia). Marconi-specific additions use the `marconi_` prefix.

### Key Vendor Libraries (in-tree)

- `inc/vendor/CMB2/` — custom meta box framework
- `inc/vendor/TGM-Plugin-Activation/` — required plugin management
- `inc/vendor/dompdf/` — PDF generation
- `assets/js/components/` — jQuery plugins (Leaflet, Splide, etc.)
