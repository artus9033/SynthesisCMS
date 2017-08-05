@extends('layouts.error')

@section('title', '503')

@section('body')
	<div class="section red lighten-2" style="height: 100vh;">
		<div class="col s12 row">
			<div class="col s12">
				<div class="container">
					<h2 class="white-text"><i class="material-icons large prefix center-on-small-only" style="vertical-align: middle;">build</i>&nbsp;{{ trans('synthesiscms/errors.503_header') }}</h2>
					<h4 class="light red-text text-lighten-4 center-on-small-only">{{ trans('synthesiscms/errors.503_desc') }}</h4>
				</div>
			</div>
			<div class="col s12 white darken-1 z-depth-3" style="margin-top: 10px;">
				<div class="container" style="margin-top: 40px; margin-bottom: 50px;">
					<h2 class="header red-text text-lighten-2">{{ trans('synthesiscms/errors.503_desc2') }}</h2>
					<button onclick="location.reload()" class="btn-large waves-effect waves-light"><i
								class="material-icons white-text left">refresh</i>&nbsp;{{ trans('synthesiscms/errors.refresh_btn') }}
					</button>
					</div>
				</div>
			</div>
		</div>
	@endsection
