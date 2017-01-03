@extends('layouts.error')

@section('title', '503')

@section('body')
	<div class="red col s12 row" style="height: 100vh;">
		<div class="card-panel z-depth-4 red-text col s8 offset-s2" style="margin-top: 15%;">
			<h2 class="center col s12 text-center">
				<i class="material-icons medium prefix" style="vertical-align: middle;">pan_tool</i>{{ trans('synthesiscms/errors.503_header') }}
			</h2>
			<div class="divider red center col s10 offset-s1" style="height: 4px; margin-top: 5px; margin-bottom: 15px;"></div>
			<h5 class="red-text center col s12">{{ trans('synthesiscms/errors.503_desc') }}</h5>
			<br>
			<h5 class="red-text center col s12">{{ trans('synthesiscms/errors.503_desc2') }}</h5>
		</div>
	</div>
@endsection
