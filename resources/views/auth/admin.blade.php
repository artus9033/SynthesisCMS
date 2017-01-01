@extends('layouts.app')

@section('head')
	<script>
	$(document).ready(function(){
    $('.scrollspy').scrollSpy();
  });
	</script>
@endsection

@section('main')
<div class="container col s12 row">
	@if(Session::has('message'))
     	    <div class="card-panel col s8 offset-s2 green white-text center" style="height: 45px;">
     	      <h5 class="center">{{ Session::get('message') }}</h5>
     	    </div>
     @endif
</div>
<div class="container col s9 row">
	<div class="col s6 offset-s3 z-depth-1 grey lighten-4 row card" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
		<div class="card-content">
			<div class="card-title">
				<h3 class="teal-text">{{ trans('synthesiscms/auth.login')}}</h3>
				</div>
				<div class="divider teal col s12"></div>
				<div class="row col s12"></div>
				<div id="users" class="section scrollspy">
<a href="/profile" class="btn btn-large teal waves-effect waves-light center hoverable"><i class="material-icons white-text left">account_circle</i>{{ trans('synthesiscms/profile.profile') }}</a>
<a href="/admin/manage_users" class="btn btn-large teal waves-effect waves-light center hoverable"><i class="material-icons white-text left">supervisor_account</i>{{ trans('synthesiscms/admin.manage_users') }}</a>
</div>
<div class="row col s12"></div>
<div >

	<a href="/admin/manage_routes" class="btn btn-large teal waves-effect waves-light center hoverable"><i class="material-icons white-text left">pages</i>{{ trans('synthesiscms/admin.manage_routes') }}</a>
	<a href="/admin/manage_extensions" class="btn btn-large teal waves-effect waves-light center hoverable"><i class="material-icons white-text left">extensions</i>{{ trans('synthesiscms/admin.manage_extensions') }}</a>

<a href="/admin/manage_routes" class="btn btn-large teal waves-effect waves-light center hoverable"><i class="material-icons white-text left">pages</i>{{ trans('synthesiscms/admin.manage_routes') }}</a>
<a href="/admin/manage_extensions" class="btn btn-large teal waves-effect waves-light center hoverable"><i class="material-icons white-text left">extensions</i>{{ trans('synthesiscms/admin.manage_extensions') }}</a>
</div>
<div id="routes" class="section scrollspy">
<a href="/admin/manage_routes" class="btn btn-large teal waves-effect waves-light center hoverable"><i class="material-icons white-text left">pages</i>{{ trans('synthesiscms/admin.manage_routes') }}</a>
<a href="/admin/manage_extensions" class="btn btn-large teal waves-effect waves-light center hoverable"><i class="material-icons white-text left">extensions</i>{{ trans('synthesiscms/admin.manage_extensions') }}</a>
</div>
<div id="settings" class="section scrollspy">
<a href="/admin/manage_routes" class="btn btn-large teal waves-effect waves-light center hoverable"><i class="material-icons white-text left">pages</i>{{ trans('synthesiscms/admin.settings') }}</a>
</div>
</div>
</div>
</div>
<div class="toc-wrapper pinned" style="position: fixed;
    z-index: 1;
    background: white;
    left: 0;
    right: 0;
    top: 0;">
	<ul class="section table-of-contents">
	  <li><a href="#users">{{ trans('synthesiscms/admin.section_users') }}</a></li>
	  <li><a href="#routes">{{ trans('synthesiscms/admin.section_routes') }}</a></li>
	  <li><a href="#settings">{{ trans('synthesiscms/admin.section_settings') }}</a></li>
	</ul>
</div>
@endsection
