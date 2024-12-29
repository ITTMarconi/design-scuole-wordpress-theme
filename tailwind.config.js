/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.html",
    "./assets-src/css/*.css",
    "./*.php",
    "./**/*.php",
    "./templates/**/*.php",
    "./assets/js/**/*.js",
  ],
  theme: {
    extend: {},
  },
  plugins: [require("tailwindcss-motion")],
};
