@extends('layouts.only_empty_body_head')

@section('main')
	<div class="col s12 z-depth-1 lighten-4 row card" style="display: inline-block; padding: 0px 48px 0px 48px; border: 1px solid #EEE;">
		<div class="card-content">
			<div class="card-title col s12">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper"><i class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">extension</i>&nbsp;{{ trans('synthesiscms/admin.manage_applets') }}</h3>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} col s12"></div>
			{{ $extension }}
		</div>
	</div>
@endsection
