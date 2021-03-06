@extends('layouts.error')

@section('title', trans('synthesiscms/errors.404_header'))

@section('body')
	<div class="section red lighten-2" style="min-height: 100vh;">
		<div class="col s12 row">
			<div class="col s12">
				<div class="container">
					<h2 class="white-text"><i class="material-icons large prefix center-on-small-only"
											  style="vertical-align: middle;">error_outline</i>&nbsp;{{ trans('synthesiscms/errors.404_header') }}
					</h2>
					<h4 class="light red-text text-lighten-4 center-on-small-only">{{ trans('synthesiscms/errors.404_desc') }}</h4>
				</div>
			</div>
			<div class="col s12 white darken-1 z-depth-3" style="margin-top: 10px;">
				<div class="container" style="margin-top: 40px; margin-bottom: 50px;">
					<h2 class="header red-text text-lighten-2">{{ trans('synthesiscms/errors.404_header2') }}</h2>
					<p class="flow-text caption">{{ trans('synthesiscms/errors.404_desc2') }}</p>
					<a href="{!! \URL::previous() !!}" class="btn-large waves-effect waves-light"><i
								class="material-icons white-text left">arrow_back</i>&nbsp;{{ trans('synthesiscms/errors.generic_back_link') }}
					</a>
					<a href="{{ url($synthesiscmsHomePage) }}" class="btn-large waves-effect waves-light"><i
								class="material-icons white-text left">home</i>&nbsp;{{ trans('synthesiscms/errors.404_link') }}
					</a>
				</div>
			</div>
		</div>
	</div>
@endsection
