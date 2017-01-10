@php
	$ct = 0;
@endphp

@foreach ($atoms as $key => $atom)
	{{ $ct++ }}
	<div class="container col s6 row">
	<div class="card hoverable z-depth-2">
		<div class="card-image waves-effect waves-block waves-light">
			<img class="activator" src="{{ $atom->image }}">
			<!-- TODO: add possibility to specify image -->
		</div>
		<div class="card-content">
			<span class="card-title activator grey-text text-darken-4"><i class="material-icons right">more_vert</i></span>
			<p>{{ $atom->title }}</p>
		</div>
		<div class="card-reveal">
			<span class="card-title grey-text text-darken-4">Card Title<i class="material-icons right">close</i></span>
			{{ $atom->content }}
		</div>
	</div>
</div>
@endforeach

@if ($ct == 0)
	@include('partials/error', ['error' => trans("hydrogen::messages.err_no_atoms")])
@endif
