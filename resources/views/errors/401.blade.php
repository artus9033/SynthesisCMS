@extends('layouts.error')

@section('title', trans("synthesiscms/errors.cmserr"))

@section('body')
	<div class="section red lighten-2" style="height: 100vh;">
		<div class="col s12 row">
			<div class="col s12">
				<div class="container">
					<h2 class="white-text"><i class="material-icons large prefix center-on-small-only" style="vertical-align: middle;">memory</i>&nbsp;{{ trans('synthesiscms/errors.cmserr_header') }}</h2>
					<h4 class="light red-text text-lighten-4 center-on-small-only">{{ trans("synthesiscms/errors.user_no_privileges") }}</h4>
				</div>
			</div>
			<div class="col s12 white darken-1 z-depth-3" style="margin-top: 10px;">
				<div class="container" style="margin-top: 40px; margin-bottom: 50px;">
					<h2 class="header red-text text-lighten-2">{{ trans('synthesiscms/errors.cmserr_header2') }}</h2>
					<p class="caption">{{ trans("synthesiscms/errors.user_no_privileges_help") }}</p>
						<a href="{{ url('/profile') }}" class="btn-large waves-effect waves-light">{{ trans('synthesiscms/errors.privileges_logout_btn') }}</a>
				</div>
			</div>
		</div>
	</div>
@endsection