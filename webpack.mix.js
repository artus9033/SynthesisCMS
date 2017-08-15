const {mix} = require('laravel-mix');

mix.options({processCssUrls: false});

//SynthesisCMS SASS
mix.sass('resources/assets/sass/app.scss', 'public/css/app.css');
mix.sass('resources/assets/sass/login-register.scss', 'public/css/login-register.css');

//Dragula JS + CSS
mix.copy('node_modules/dragula/dist/dragula.js', 'public/js/dragula.js');
mix.copy('node_modules/dragula/dist/dragula.css', 'public/css/dragula.css');

//MaterializeCSS SASS + JS + Roboto font
mix.sass('resources/assets/materializecss/sass/materialize.scss', 'public/css/materialize.css');
//mix.js('resources/assets/materializecss/js/bin/materialize.js', 'public/js/materialize.js');
//TODO: fix this, because self compiling causes problems with Jquery's velocity animations
mix.copy('resources/assets/materializecss/dist-js', 'public/js', false);
mix.copy('resources/assets/materializecss/fonts', 'public/fonts', false);

//Chart.js, Clipboard.js & Trumbowyg
mix.copy('node_modules/chart.js/dist/Chart.js', 'public/js');
mix.copy('node_modules/clipboard/dist/clipboard.min.js', 'public/js/clipboard.min.js');
mix.copy('node_modules/trumbowyg/dist', 'public/trumbowyg', false);

//SynthesisCMS resources, trumbowyg resources, artus9033's Trumbowyg addons, MaterializeCSS fonts
mix.copy('resources/assets/img', 'public/img', false);
mix.copy('resources/assets/fonts', 'public/fonts', false);
mix.copy('resources/assets/js-copy-only', 'public/js', false);
mix.copy('resources/assets/artus9033-trumbowyg', 'public/trumbowyg/plugins/artus9033', false);
mix.copy('resources/assets/trumbowyg-custom-icons/icons.svg', 'public/trumbowyg/ui/icons.svg');