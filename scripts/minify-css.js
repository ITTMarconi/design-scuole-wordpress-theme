const CleanCSS = require("clean-css");
const fs = require("fs");

const CSS_SOURCES = [
  "./assets-src/css/scuole-marconi.css",
  "./assets-src/css/overrides.css",
  "./assets-src/css/admin-style.css",
];

CSS_SOURCES.forEach((path) => {
  if (fs.existsSync(path)) {
    fs.writeFileSync(
      path.replace("assets-src", "assets"),
      new CleanCSS().minify(fs.readFileSync(path, "utf8")).styles,
    );
  }
});
