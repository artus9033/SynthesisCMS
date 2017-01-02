@extends('layouts.app')

@section('title')
	{{ trans('synthesiscms/admin.backend')}}
@endsection

@section('breadcrumbs')
<a href="/admin" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
@endsection

@section('head')
	<script>
	$(document).ready(function(){
		$('.scrollspy').scrollSpy();
	});
	</script>
@endsection

@section('main')
	<div class="container col s12 row">
		<div class="col s8 offset-s2 z-depth-1 grey lighten-4 row card" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
			<div class="card-content">
				<div class="card-title">
					<h2 class="card-panel teal white-text">{{ trans('synthesiscms/admin.backend')}}</h2>
				</div>
				<div class="row col s12"></div>
				<div id="users" class="section scrollspy">
					<h3 class="teal-text col s12 center">{{ trans('synthesiscms/admin.section_users') }}</h3>
					<div class="divider teal col s12"></div>
					<div class="row col s12"></div>
					<a href="/profile" class="btn btn-large teal waves-effect waves-light center hoverable"><i class="material-icons white-text left">account_circle</i>{{ trans('synthesiscms/profile.profile') }}</a>
					<a href="/admin/manage_users" class="btn btn-large teal waves-effect waves-light center hoverable"><i class="material-icons white-text left">supervisor_account</i>{{ trans('synthesiscms/admin.manage_users') }}</a>
				</div>
				<div class="row col s12"></div>
				<div id="routes" class="section scrollspy">
					<h3 class="teal-text col s12 center">{{ trans('synthesiscms/admin.section_routes') }}</h3>
					<div class="divider teal col s12"></div>
					<div class="row col s12"></div>
					<a href="/admin/manage_routes" class="btn btn-large teal waves-effect waves-light center hoverable"><i class="material-icons white-text left">pages</i>{{ trans('synthesiscms/admin.manage_routes') }}</a>
					<a href="/admin/manage_extensions" class="btn btn-large teal waves-effect waves-light center hoverable"><i class="material-icons white-text left">extensions</i>{{ trans('synthesiscms/admin.manage_extensions') }}</a>
				</div>
				<div id="settings" class="section scrollspy">
					<h3 class="teal-text col s12 center">{{ trans('synthesiscms/admin.section_settings') }}</h3>
					<div class="divider teal col s12"></div>
					<div class="row col s12"></div>
					<a href="/admin/settings" class="btn btn-large teal waves-effect waves-light center hoverable"><i class="material-icons white-text left">pages</i>{{ trans('synthesiscms/admin.settings') }}</a>
				</div>
			</div>
		</div>
	</div>
	<div class="toc-wrapper pinned" style="position: fixed; z-index: 1; right: 0; top: 40%;">
		<ul class="section table-of-contents">
			<li><a class="synthesis" href="#users">{{ trans('synthesiscms/admin.section_users') }}</a></li>
			<li><a class="synthesis" href="#routes">{{ trans('synthesiscms/admin.section_routes') }}</a></li>
			<li><a class="synthesis" href="#settings">{{ trans('synthesiscms/admin.section_settings') }}</a></li>
		</ul>
	</div>
@endsection
