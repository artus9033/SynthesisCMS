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
				<span class="card-title grey-text text-darken-4">{{ $atom->title }}<i class="material-icons right">close</i></span>
				{{ $atom->description }}
			</div>
		@else
			<div class="card-title">
				<div class="col s10">
				<p class="truncate left">
					{{ $atom->title }}
				</p>
			</div>
			<div class="col s2">
				<a href="{{ $base_slug }}/atom/{{ $atom->id }}"><i class="material-icons teal-text">open_in_new</i></a>
			</div>
			</div>
		@endif
		<div class="card-content">
			@if($atom->hasImage)
				<span class="card-title activator grey-text text-darken-4 left">
					<a href="{{ $base_slug }}/atom/{{ $atom->id }}"><i class="material-icons teal-text right">more_vert</i></a>
				</span>
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
