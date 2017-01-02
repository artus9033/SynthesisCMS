@extends('layouts.app')

@section('title')
	{{ trans('synthesiscms/admin.manage_users')}}
@endsection

@section('breadcrumbs')
	<a href="/admin" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="/admin/manage_users" class="breadcrumb">{{ trans('synthesiscms/admin.manage_users') }}</a>
@endsection

@section('main')
	<div class="col s12 z-depth-1 grey lighten-4 row card" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
		<div class="card-content">
			<div class="card-title col s12">
				<h3 class="teal-text valign-wrapper"><i class="material-icons prefix teal-text medium valign">supervisor_account</i>&nbsp;{{ trans('synthesiscms/auth.profile') }}</h5>
				</div>
				<div class="divider teal col s12"></div>
				<div class="col s12 row"></div>
				<div class="col s12 row">
					<table class="bordered col s12">
						<thead>
							<tr>
								<th data-field="id" class="center">{{ trans('synthesiscms/profile.id') }}</th>
								<th data-field="name" class="center">{{ trans('synthesiscms/profile.name') }}</th>
								<th data-field="email" class="center">{{ trans('synthesiscms/profile.email') }}</th>
								<th data-field="rights" class="center">{{ trans('synthesiscms/profile.rights') }}</th>
								<th data-field="edit" class="center">{{ trans('synthesiscms/profile.edit_rights') }}</th>
								<th data-field="delete" class="center">{{ trans('synthesiscms/profile.delete') }}</th>
							</tr>
						</thead>
						<tbody>
								@php
									use \App\User;
									$usr_count = 0;
									$all_users = User::all();
								@endphp
								@foreach ($all_users as $user)
									@if (\Auth::user()->id != $user->id)
										@php
											$usr_count = $usr_count + 1;
											$uid = $user->id;
										@endphp
										<tr>
											<td class="center">{{ $uid }}</td>
											<td class="center">{{ $user->name }}</td>
											<td class="center">{{ $user->email }}</td>
											<td class="center">@php if($user->is_admin){ echo trans('synthesiscms/profile.admin'); }else{ echo trans('synthesiscms/profile.user'); } @endphp</td>
											<td class="center"><a href="/admin/user-privileges/{{ $uid }}" class="btn teal waves-effect waves-light hoverable"><i class="material-icons white-text left">security</i>{{ trans('synthesiscms/admin.change_user_privileges') }}</a></td>
											<td class="center"><a href="/profile/delete/{{ $uid }}" class="btn teal waves-effect waves-light hoverable"><i class="material-icons white-text left">security</i>{{ trans('synthesiscms/admin.delete_user') }}</a></td>
										</tr>
									@endif
								@endforeach
								@if ($usr_count == 0)
									<tr><td colspan="6" class="center">{{ trans('synthesiscms/admin.no_other_users') }}</td></tr>
								@endif
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	@endsection
