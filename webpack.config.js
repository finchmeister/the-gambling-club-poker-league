var Encore = require('@symfony/webpack-encore');

Encore
// the project directory where all compiled assets will be stored
    .setOutputPath('web/build/')

    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    //.addEntry('app', './assets/js/app.js')
    .addStyleEntry('css/app', './assets/css/app.scss')
    .autoProvidejQuery()
    .enableSourceMaps(!Encore.isProduction())
    .enableBuildNotifications()
    .enableSassLoader()
    .enableVersioning()
;

// export the final configuration
module.exports = Encore.getWebpackConfig();