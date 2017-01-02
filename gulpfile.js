const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

elixir(mix => {
	mix.sass('app.scss');

	mix.sass('materializecss/materialize.scss');

	mix.sass('loginregister.scss');

	mix.copy('resources/assets/img', 'public/img');
});
