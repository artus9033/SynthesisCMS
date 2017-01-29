@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.backend')}}
@endsection

@section('breadcrumbs')
	<a href="/admin" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
@endsection

@section('brand-logo')
	{{ trans('synthesiscms/admin.backend') }}
@endsection

@section('main')
	<div class="container col s12 row">
		<div class="col s12 z-depth-1 grey lighten-4 row card" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
			<div class="card-content">
				<div class="card-title center">
					<h2 class="card-panel {{ $synthesiscmsMainColor }} white-text"><i class="material-icons white-text medium left valign" style="line-height: unset !important;">graphic_eq</i>{{ trans('synthesiscms/admin.stats') }}</h2>
				</div>
				<div class="row col s12"></div>
				<div class="section">
					<canvas id="stats" class="col s12" height="300"></canvas>
					<script type="text/javascript" src="{!! asset('js/Chart.js') !!}"></script>
					<script type="text/javascript">
					window.trans = {
						amount_of_views: "{{ trans('synthesiscms/stats.views_amount') }}",
					};
					</script>
					<script type="text/javascript" src="{!! asset('js/admin-stats.js') !!}"></script>
				</div>
			</div>
		</div>
	</div>
@endsection
