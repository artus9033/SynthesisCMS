const {mix} = require('laravel-mix');

//Before doing anything, copy overriden materializecss' _variables.sscs (fixes error with fonts path during compilation)
mix.copy('resources/assets/sass/materializecss_override_variables.scss', 'resources/assets/sass/materializecss/components/_variables.scss');

//SynthesisCMS SASS
mix.sass('resources/assets/sass/app.scss', 'public/css/app.css');
mix.sass('resources/assets/sass/login-register.scss', 'public/css/login-register.css');

//MaterializeCSS SASS + JS
mix.sass('resources/assets/sass/materializecss/materialize.scss', 'public/css/materialize.css');
mix.js('resources/assets/js-webpack-only/materializecss/bin/materialize.js', 'public/js/materialize.js');

//Chart.js, Clipboard.js & Trumbowyg
mix.copy('node_modules/chart.js/dist/Chart.js', 'public/js');
mix.copy('node_modules/clipboard/dist/clipboard.min.js', 'public/js/clipboard.min.js');
mix.copy('node_modules/trumbowyg/dist', 'public/trumbowyg');

//SynthesisCMS resources, trumbowyg resources, artus9033's Trumbowyg addons, MaterializeCSS fonts
mix.copy('resources/assets/img', 'public/img');
mix.copy('resources/assets/fonts', 'public/fonts');
mix.copy('resources/assets/js-copy-only', 'public/js');
mix.copy('resources/assets/artus9033-trumbowyg', 'public/trumbowyg/plugins/artus9033');
mix.copy('resources/assets/trumbowyg-custom-icons/icons.svg', 'public/trumbowyg/ui/icons.svg');
