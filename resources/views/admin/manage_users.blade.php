@extends('layouts.admin')

@section('title')
	{{ trans('synthesiscms/admin.manage_users')}}
@endsection

@section('side-nav-active-zero-indexed', 1)

@section('breadcrumbs')
	<a href="{{ route('admin') }}" class="breadcrumb">{{ trans('synthesiscms/admin.backend') }}</a>
	<a href="{{ route('manage_users') }}" class="breadcrumb">{{ trans('synthesiscms/admin.manage_users') }}</a>
@endsection

@section('main')
	<div>
		<div class="card-content no-padding">
			<div class="card-title col s12">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper"><i
							class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">supervisor_account</i>&nbsp;{{ trans('synthesiscms/admin.manage_users') }}
				</h3>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
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
						use \App\Models\Auth\User;
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
								<td class="center">
									<a href="{{ route('user_privileges', ['id' => $uid]) }}"
										class="btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light hoverable">
											<i class="material-icons white-text left">edit</i>
											{{ trans('synthesiscms/admin.change_user_privileges') }}
									</a>
								</td>
								<div id="modalDelete-{!! $uid !!}" class="modal">
									<div class="modal-content">
										<h3>{{ trans('synthesiscms/admin.modal_delete_user_header') }}</h3>
										<div class="row col s12">
											<div class="divider red col s10 offset-s1" style="height: 2px;"></div>
										</div>
										<h5>{{ trans('synthesiscms/admin.modal_delete_user_content') }}</h5>
										<h5 class="red-text darken-1">
											<strong>{{ trans('synthesiscms/admin.modal_delete_user_content_2') }}</strong>
										</h5>
									</div>
									<div class="modal-footer">
										<a style="margin-right: 9%;" onclick="$('#modalDelete-{!! $uid !!}').modal('close');"
										   class="modal-action modal-close waves-effect waves-green btn-flat right">{{ trans('synthesiscms/admin.modal_delete_user_btn_no') }}</a>
										<a style="margin-left: 9%;" href="{{ route('profile_delete', ['id' => $uid]) }}"
										   class="modal-action red white-text modal-close waves-effect waves-light btn-flat left">{{ trans('synthesiscms/admin.modal_delete_user_btn_yes') }}</a>
									</div>
								</div>
								<td class="center">
									<button onclick="$('#modalDelete-{!! $uid !!}').modal('open');"
											class="btn {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} waves-effect waves-light hoverable">
										<i class="material-icons white-text left">delete</i>{{ trans('synthesiscms/admin.delete_user') }}
									</button>
								</td>
							</tr>
						@endif
					@endforeach
					@if ($usr_count == 0)
						<tr>
							<td colspan="6" class="center">{{ trans('synthesiscms/admin.no_other_users') }}</td>
						</tr>
					@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<script type="text/javascript">
        $(document).ready(function () {
            $('.modal').modal({
                    dismissible: false
                }
            );
        });
	</script>
@endsection
