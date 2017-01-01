@extends('layouts.app')

@section('main')
<div class="container col s12 row">
	@if(Session::has('message'))
     	    <div class="card-panel col s8 offset-s2 green white-text center" style="height: 45px;">
     	      <h5 class="center">{{ Session::get('message') }}</h5>
     	    </div>
     @endif
</div>
<div class="container col s12 row">
<a href="/profile" class="btn teal waves-effect waves-light center hoverable"><i class="material-icons white-text left">account_circle</i>{{ trans('synthesiscms/profile.profile') }}</a>
<a href="/admin/manage_users" class="btn teal waves-effect waves-light center hoverable"><i class="material-icons white-text left">supervisor_account</i>{{ trans('synthesiscms/profile.manage_users') }}</a>
</div>
@endsection
