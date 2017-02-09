@foreach ($atoms as $key => $atom)
	@php
	$atom_href = "";
	if($base_slug != url("/") || $base_slug != "/"){
		$atom_href = url($base_slug);
	}
	@endphp
	<div class="container col s12 row">
		<div class="card hoverable z-depth-2 center">
			@if($atom['hasImage'])
				<div class="card-image waves-effect waves-block waves-light">
					<img class="activator" src="{{ $atom['image'] }}">
				</div>
				<div class="card-reveal">
					<span class="card-title col s12"><span class="left">{{ $atom['title'] }}</span><i class="material-icons {{ $synthesiscmsMainColor }}-text right">close</i><a href="{{ url($atom_href) }}/atom/{{ $atom['id'] }}"><i class="material-icons right">open_in_new</i></a></span>
					<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12" style="margin-top: 5px; margin-bottom: 10px;"></div>
					{!! $atom['description'] !!}
				</div>
			@else
				<div class="card-title">
					<div class="col s12" style="height: 15px;"></div>
					<div class="col s10">
						<p class="truncate left">
							&nbsp;&nbsp;{{ $atom['title'] }}
						</p>
					</div>
					<div class="col s2">
						<a href="{{ url($atom_href) }}/atom/{{ $atom['id'] }}"><i class="material-icons {{ $synthesiscmsMainColor }}-text">open_in_new</i></a>
					</div>
				</div>
			@endif
			<div class="card-content">
				@if($atom['hasImage'])
					<span class="card-title activator" style="text-align: left;">
						{{ $atom['title'] }}
						<i class="material-icons right">more_vert</i>
					</span>
					<p class="{{ $synthesiscmsMainColor }}-text" id="artificial-link" style="text-align: left;" onclick="window.location.href='{{ url($atom_href) }}/atom/{{ $atom['id'] }}'">{{ trans("Hydrogen::hydrogen.atom_card_link_read") }}</p>
					<style>
						#artificial-link:hover{
							cursor: pointer;
						}
					</style>
				@else
					<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12" style="margin-top: 5px; margin-bottom: 10px;"></div>
					{!! $atom['description'] !!}
				@endif
			</div>
		</div>
	</div>
@endforeach
