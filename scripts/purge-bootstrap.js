/**
 * Tree-shake Bootstrap Italia.
 *
 * We use ~6% of bootstrap-italia.css (see docs/bootstrap-italia-inventory.md).
 * This produces a purged copy that is what the theme actually enqueues, while
 * the full vendor file stays in the repo as the SOURCE / fallback: if a rule
 * turns out missing, add its class to the safelist below and re-run, or
 * temporarily enqueue the full file again.
 *
 *   in : assets/css/bootstrap-italia.css        (full vendor, source of truth)
 *   out: assets/css/bootstrap-italia.purged.css  (generated, enqueued)
 *
 * Run: npm run purge:bs   (also part of `npm run build`)
 *
 * Safety: only unused *selector rules* are dropped. CSS variables, @keyframes
 * and @font-face are all kept. The safelist covers classes that are added at
 * runtime by JS (Bootstrap Italia / scuole.js) or by other libs (Splide), which
 * static scanning of the markup cannot see.
 */
const { PurgeCSS } = require("purgecss");
const fs = require("fs");

const SRC = "./assets/css/bootstrap-italia.css";
const OUT = "./assets/css/bootstrap-italia.purged.css";

(async () => {
  if (!fs.existsSync(SRC)) {
    console.error("purge:bs — source not found: " + SRC);
    process.exit(1);
  }

  const result = await new PurgeCSS().purge({
    // Where the classes actually used live: theme markup + theme JS.
    content: [
      "./*.php",
      "./template-parts/**/*.php",
      "./page-templates/**/*.php",
      "./walkers/**/*.php",
      "./inc/**/*.php",
      "!./inc/vendor/**",
      "./assets/js/scuole.js",
      "./assets/js/marconi/**/*.js",
    ],
    css: [SRC],
    // Keep these regardless of static scanning.
    variables: false, // do not strip CSS custom properties
    keyframes: false, // do not strip @keyframes
    fontFace: false, // do not strip @font-face
    safelist: {
      standard: [
        // Bootstrap Italia / scuole.js runtime state classes
        "show", "fade", "collapse", "collapsing", "collapsed",
        "active", "disabled", "open", "selected",
        "is-active", "is-sticky", "sticked-menu", "sticked-menu-body",
        "menu-open", "modal-open", "modal-backdrop",
        "focus", "focus--mouse", "focus-mouse", "utils-moved", "zoom",
        "dropdown", "dropdown-menu", "dropdown-toggle",
        "sr-only", "sr-only-focusable",
      ],
      greedy: [
        /^modal/,       // modal variants/states toggled by JS
        /backdrop/,
        /^is-/,         // is-* state classes
        /^sticked/,
        /^push-body/,   // jPushMenu body states
        /menu-open/,
        /^splide/,      // Splide classes (BI carousel rules reference them)
        // Pagination is generated at runtime by WordPress (paginate_links / the
        // theme walker), so its classes + the [aria-current] current-page rule
        // are not visible to static scanning. Keep the whole family.
        /pagination/,
        /page-link/,
        /page-item/,
        /page-numbers/,
      ],
    },
  });

  fs.writeFileSync(OUT, result[0].css);

  const before = fs.statSync(SRC).size;
  const after = fs.statSync(OUT).size;
  const pct = Math.round((1 - after / before) * 1000) / 10;
  console.log(
    `purge:bs — ${(before / 1024).toFixed(0)} KB → ${(after / 1024).toFixed(0)} KB (-${pct}%)  ${OUT}`
  );
})();
