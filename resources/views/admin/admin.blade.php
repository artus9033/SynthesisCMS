@extends('layouts.app')

@section('head')
	<script type="text/javascript" src="{!! asset('js/Chart.js') !!}"></script>
	<script>
	$(document).ready(function(){
		$('.collapsible').collapsible();
	});
	</script>
	<style>
	body{
		padding-left: 300px;
	}
	</style>
@endsection

@section('title')
	{{ trans('synthesiscms/admin.backend')}}
@endsection

@section('breadcrumbs')
	<a href="/admin" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
@endsection

@section('brand-logo')
	{{ trans('synthesiscms/admin.backend') }}
@endsection

@section('header')
	<ul id="nav-mobile" class="side-nav fixed" style="transform: translateX(0px);">
		<li class="logo"><a href="/admin" class="brand-logo teal white-text waves-effect waves-light"><i class="material-icons white-text">verified_user</i>{{ trans('synthesiscms/admin.backend') }}</a></li>
		<li>
			<ul class="collapsible collapsible-accordion">
				<li class="bold"><a class="collapsible-header waves-effect waves-teal"><i class="material-icons teal-text">supervisor_account</i>{{ trans('synthesiscms/admin.section_users') }}</a>
					<div class="collapsible-body">
						<ul>
							<li><a class="waves-effect waves-teal" href="/profile">{{ trans('synthesiscms/profile.profile') }}</a></li>
							<li><a class="waves-effect waves-teal" href="/admin/manage_users">{{ trans('synthesiscms/admin.manage_users') }}</a></li>
						</ul>
					</div>
				</li>
				<li class="bold"><a class="collapsible-header waves-effect waves-teal"><i class="material-icons teal-text">pages</i>{{ trans('synthesiscms/admin.section_routes') }}</a>
					<div class="collapsible-body">
						<ul>
							<li><a class="waves-effect waves-teal" href="/admin/manage_routes">{{ trans('synthesiscms/admin.manage_routes') }}</a></li>
							<li><a class="waves-effect waves-teal" href="/admin/manage_extensions">{{ trans('synthesiscms/admin.manage_extensions') }}</a></li>
						</ul>
					</div>
				</li>
				<li class="bold active"><a class="collapsible-header waves-effect waves-teal"><i class="material-icons teal-text">settings</i>{{ trans('synthesiscms/admin.section_settings') }}</a>
					<div class="collapsible-body" style="display: block;">
						<ul>
							<li><a class="waves-effect waves-teal" href="/admin/settings">{{ trans('synthesiscms/admin.settings') }}</a></li>
						</ul>
					</div>
				</li>
			</ul>
		</li>
	</ul>
@endsection

@section('main')
	<div class="container col s12 row">
		<div class="col s12 z-depth-1 grey lighten-4 row card" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
			<div class="card-content">
				<div class="card-title center">
					<h2 class="card-panel teal white-text"><i class="material-icons white-text medium left valign">graphic_eq</i>{{ trans('synthesiscms/admin.stats') }}</h2>
				</div>
				<div class="row col s12"></div>
				<div class="section">
					<canvas id="myChart" class="col s12" height="auto"></canvas>
				</div>
			</div>
		</div>
	</div>
@endsection
