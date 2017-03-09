const { mix } = require('laravel-mix');
	mix.sass('app.scss');

	mix.sass('materializecss/materialize.scss');

	mix.sass('facebook-likebox-slideout.scss');

	mix.copy('resources/assets/img', 'public/img');

	mix.copy('resources/assets/fonts', 'public/fonts');

	mix.copy('resources/js-copy-only', 'public/js');

	//mix.copy('resources/assets/js/facebook_sdk.js', 'public/js')

	mix.copy('node_modules/chart.js/dist/Chart.js', 'public/js');

	mix.copy('node_modules/clipboard/dist/clipboard.min.js', 'public/js/clipboard.min.js');

	mix.copy('node_modules/trumbowyg/dist', 'public/trumbowyg');
