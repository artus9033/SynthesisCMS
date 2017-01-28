@php
$ct = 0;
@endphp

@foreach ($atoms as $key => $atom)
	@php
	$ct++
	@endphp
	<div class="container col s6 row">
		<div class="card hoverable z-depth-2 center">
			@if($atom->hasImage)
				<div class="card-image waves-effect waves-block waves-light">
					<img class="activator" src="{{ $atom->image }}">
				</div>
				<div class="card-reveal">
					<span class="card-title col s12"><span class="left">{{ $atom->title }}</span><i class="material-icons teal-text right">close</i><a href="{{ $base_slug }}/atom/{{ $atom->id }}"><i class="material-icons right">open_in_new</i></a></span>
					<div class="divider teal col s12" style="margin-top: 5px; margin-bottom: 10px;"></div>
					{!! $atom->description !!}
				</div>
			@else
				<div class="card-title">
					<div class="col s12" style="height: 15px;"></div>
					<div class="col s10">
						<p class="truncate left">
							&nbsp;&nbsp;{{ $atom->title }}
						</p>
					</div>
					<div class="col s2">
						<a href="{{ $base_slug }}/atom/{{ $atom->id }}"><i class="material-icons teal-text">open_in_new</i></a>
					</div>
				</div>
			@endif
			<div class="card-content">
				@if($atom->hasImage)
					<span class="card-title activator" style="text-align: left;">
						Card Title
						<i class="material-icons right">more_vert</i>
					</span>
					<p class="teal-text" id="artificial-link" style="text-align: left;" onclick="window.location.href='{{ $base_slug }}/atom/{{ $atom->id }}'">{{ trans("hydrogen::hydrogen.atom_card_link_read") }}</p>
					<style>
						#artificial-link:hover{
							cursor: pointer;
						}
					</style>
				@else
					<div class="divider teal col s12" style="margin-top: 5px; margin-bottom: 10px;"></div>
					{!! $atom->description !!}
				@endif
			</div>
		</div>
	</div>
@endforeach

@if ($ct == 0)
	@include('partials/error', ['error' => trans("hydrogen::messages.err_no_atoms")])
@endif
