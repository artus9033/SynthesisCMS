@extends('layouts.only_empty_body_head')

@section('main')
	@php
		$kpath = 'App\\Extensions\\' . $extension . '\\ExtensionKernel';
		$kernel = new $kpath;
	@endphp
	<div class="col s12 z-depth-1 lighten-4 row card" style="display: inline-block; border: 1px solid #EEE;">
		<div class="card-content">
			<div class="card-title col s12">
				<h3 class="{{ $synthesiscmsMainColor }}-text valign-wrapper"><i
							class="material-icons prefix {{ $synthesiscmsMainColor }}-text medium valign">settings</i>&nbsp;{{ trans('synthesiscms/admin.applet_settings', ['applet' => $kernel->getExtensionName()]) }}
				</h3>
			</div>
			<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"></div>
			<form id="form" class="col s12 row" method="post" action="{{ route("applet_settings", $extension) }}">
				{{ csrf_field() }}
				{!! $kernel->settingsGet() !!}
				<button type="submit"
						class="col s12 center text-center btn-flat waves-effect waves-{{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">{{ trans('synthesiscms/admin.save_applet') }}</button>
			</form>
		</div>
	</div>
@endsection
