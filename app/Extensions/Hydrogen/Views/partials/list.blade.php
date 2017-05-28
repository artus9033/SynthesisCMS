@foreach ($articles as $key => $article)
	@php
		$article_href = "";
		if($base_slug != url("/") || $base_slug != "/"){
			$article_href = url($base_slug);
		}
	@endphp
	<div class="container col s12 row">
		<div class="card {{ $article['cardSize'] }} hoverable z-depth-2 center">
			@if($article['hasImage'])
				<div class="card-image waves-effect waves-block waves-light">
					<img class="activator" src="{{ $article['image'] }}">
				</div>
				<div class="card-reveal">
					<span class="card-title col s12"><span class="left">{{ $article['title'] }}</span><i
								class="material-icons {{ $synthesiscmsMainColor }}-text right">close</i><a
								href="{{ url($article_href) }}/article/{{ $article['id'] }}"><i
									class="material-icons {{ $synthesiscmsMainColor }}-text right">open_in_new</i></a></span>
					<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12" style="margin-top: 5px; margin-bottom: 10px;"></div>
					{!! $article['description'] !!}
				</div>
			@else
				<div class="card-title">
					<div class="col s12" style="height: 15px;"></div>
					<div class="col s10">
						<p class="truncate left">
							&nbsp;&nbsp;{{ $article['title'] }}
						</p>
					</div>
					<div class="col s2">
						<a href="{{ url($article_href) }}/article/{{ $article['id'] }}"><i
									class="material-icons {{ $synthesiscmsMainColor }}-text">open_in_new</i></a>
					</div>
				</div>
			@endif
			<div class="card-content">
				@if($article['hasImage'])
					<span class="card-title activator" style="text-align: left;">
						{{ $article['title'] }}
						<i class="material-icons right">more_vert</i>
					</span>
					<p class="{{ $synthesiscmsMainColor }}-text" id="artificial-link" style="text-align: left;"
					   onclick="window.location.href='{{ url($article_href) }}/article/{{ $article['id'] }}'">{{ trans("Hydrogen::hydrogen.article_card_link_read") }}</p>
					<style>
						#artificial-link:hover{
							cursor: pointer;
						}
					</style>
				@else
					<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12" style="margin-top: 5px; margin-bottom: 10px;"></div>
					{!! $article['description'] !!}
				@endif
			</div>
		</div>
	</div>
@endforeach
