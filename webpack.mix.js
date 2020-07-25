const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js/app.js")
    .js("resources/js/admin/app.js", "public/js/admin.js")
    .js("resources/js/ethics/app.js", "public/js/ethics.js")

    .sass("resources/sass/app.scss", "public/css")
    .sass("resources/sass/admin.scss", "public/css/admin.css")
    .sass("resources/sass/ethics.scss", "public/css/ethics.css")
    //
    .extract(["vue", "vuetify"])
    .sourceMaps();

if (mix.inProduction()) {
    mix.version().options({
        // Optimize JS minification process
        terser: {
            cache: true,
            parallel: true,
            sourceMap: true
        }
    });
} else {
    // Uses inline source-maps on development
    mix.webpackConfig({
        devtool: "inline-source-map"
    });
}
