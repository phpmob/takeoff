const Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const path = require('path');
const Chang = {
    ui: path.resolve(__dirname, 'vendor/phpmob/chang/src/UI/Resources/private'),
    base: path.resolve(__dirname, 'vendor/phpmob/chang/src/Application/Resources/private'),
    messenger: path.resolve(__dirname, 'vendor/phpmob/chang/src/Messenger/Resources/private'),
};

Encore
    .addAliases({
        'ui': Chang.ui,
        'chang': Chang.base,
    })
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    // It will provide jquery for all .addEntry() that contains `$|jQuery`
    // but we need single jquery instance for all entries.
    // see note in app.js/msg.js for fixing.
    //.autoProvidejQuery()
    .enablePostCssLoader()
    .enableSassLoader(function (options) {
        options.importer = function (url, prev) {
            if (url.indexOf('@chang') === 0) {
                url = `${Chang.base}/${url}`.replace('@chang', '');
            } else if (url.indexOf('@ui') === 0) {
                url = `${Chang.ui}/${url}`.replace('@ui', '');
            } else if (url.indexOf('@') === 0) {
                const nodeModulePath = `./node_modules/${url}`;
                url = require('path').resolve(nodeModulePath)
            } else if (url.indexOf('~') === 0) {
                const filePath = url.split('~')[1];
                const nodeModulePath = `./node_modules/${filePath}`;
                url = require('path').resolve(nodeModulePath)
            }

            return {
                file: url
            };
        }
    })
    // https://github.com/HubSpot/pace/issues/328
    .addLoader(
        {
            test: require.resolve("pace-progress"),
            loader: "imports-loader?define=>false"
        }
    )

    .addEntry('msg', `${Chang.messenger}/js/msg.js`)
    .addStyleEntry('flatpickr', './node_modules/flatpickr/dist/flatpickr.css')
    .addStyleEntry('confirm', './node_modules/jquery-confirm/dist/jquery-confirm.min.css')
    .addStyleEntry('animate', './node_modules/animate.css/animate.min.css')

    // admin
    .addEntry('admin/app', './private/admin/app.js')
    .addStyleEntry('admin/style', './private/admin/app.scss')

    .addPlugin(new CopyWebpackPlugin([
        { from: `${Chang.messenger}/web-push/**`, to: 'web-push', flatten: true },
        { from: `${Chang.messenger}/sounds/**`, to: 'sounds', flatten: true },
    ]))
;

module.exports = Encore.getWebpackConfig();
