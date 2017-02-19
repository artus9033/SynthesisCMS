@extends('layouts.admin')

@section('head')
	<style>
		.caret {
		  color: {{ $synthesiscmsMainColor }} !important;
		}

		.select-dropdown {
		  border-bottom-color: {{ $synthesiscmsMainColor }} !important;
		}

		.select-wrapper {
		  margin-top: 5px !important;
		}
	</style>
@endsection

@section('title')
{{ trans('synthesiscms/admin.change_user_privileges')}}
@endsection

@section('side-nav-active', 'manage_users')

@section('breadcrumbs')
<a href="{{ url('/admin') }}" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
<a href="{{ url('/admin/manage_users') }}" class="breadcrumb">{{ trans('synthesiscms/admin.manage_users') }}</a>
<a class="breadcrumb">{{ trans('synthesiscms/admin.change_user_privileges') }}</a>
@endsection

@section('main')
<div>
	<div class="card-content">
		<div class="card-title col s12">
			<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper"><i class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">security</i>&nbsp;{{ trans('synthesiscms/admin.change_name_privileges', ['name' => $uname]) }}</h5>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
			<div class="col s12 row"></div>
			<div class="col s12 row">
				<form class="form-horizontal col s12 valign-wrapper" role="form" method="POST" action="">
					{{ csrf_field() }}
				<div class="input-field col s8 valign">
					<select id="is_admin" name="is_admin" class="{{ $synthesiscmsMainColor }}-text">
						<option value="false" @php if($priv == false){ echo("selected"); } @endphp>{{ trans('synthesiscms/profile.user') }}</option>
						<option value="true" @php if($priv == true){ echo("selected"); } @endphp>{{ trans('synthesiscms/profile.admin') }}</option>
					</select>
				</div>
				<button type="submit" class="valign col s4 text-center btn btn-large waves-effect waves-light {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"><i class="material-icons white-text right">send</i>{{ trans('synthesiscms/admin.change_user_privileges') }}</button>
			</form>
			</div>
		</div>
	</div>
	@endsection
