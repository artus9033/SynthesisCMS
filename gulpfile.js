//const { mix } = require('laravel-mix');
//TODO: use mix instead of gulp => find fix

const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

elixir(mix => {
	mix.sass('app.scss');
	mix.sass('login-register.scss');
	mix.sass('materializecss/materialize.scss');

    //mix.js('resources/assets/js-webpack-only');

    mix.copy('node_modules/chart.js/dist/Chart.js', 'public/js');
    mix.copy('node_modules/clipboard/dist/clipboard.min.js', 'public/js/clipboard.min.js');
    mix.copy('node_modules/trumbowyg/dist', 'public/trumbowyg');

    mix.copy('resources/assets/img', 'public/img');
    mix.copy('resources/assets/fonts', 'public/fonts');
    mix.copy('resources/assets/js-copy-only', 'public/js');
    mix.copy('resources/assets/artus9033-trumbowyg', 'public/trumbowyg/plugins/artus9033');
    mix.copy('resources/assets/trumbowyg-custom-icons/icons.svg', 'public/trumbowyg/ui/icons.svg');
});
