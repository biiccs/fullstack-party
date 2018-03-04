var Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
    .addEntry('js/main', './assets/js/main.js')
    .addStyleEntry('css/main', './assets/css/main.scss')
    .addStyleEntry('css/app', './assets/css/app.scss')
    .addEntry('logo', './assets/images/logo.png')
    .addEntry('img', './assets/images/img.jpg')

    // uncomment if you use Sass/SCSS files
    .enableSassLoader(function(sassOptions) {}, {
        resolveUrlLoader: false
    })
    // uncomment for legacy applications that require $/jQuery as a global variable
    .autoProvidejQuery()

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // show OS notifications when builds finish/fail
    .enableBuildNotifications()


;

module.exports = Encore.getWebpackConfig();
