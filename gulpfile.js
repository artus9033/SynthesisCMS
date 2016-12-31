const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

elixir(mix => {
	mix.sass('app.scss');

	mix.sass('materializecss/materialize.scss').webpack('materialize.js');

	mix.copy('resources/assets/js/jquery-3.1.1.min.js', 'public/js/');

	mix.copy('resources/assets/img', 'public/img');
});
