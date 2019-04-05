@foreach ($articles as $key => $article)
	@php
		$article_href = "";
		if($base_slug != url("/") || $base_slug != "/"){
			$article_href = url($base_slug);
		}
	$articleTargetUrl = url($article_href) . "/article/" . $article->id; 
	@endphp
	<div class="col s12 row">
		<div class="card hoverable z-depth-2 center">
			@if($article->hasImage)
				<div class="card-image {{ $article->cardSize }}">
					<div style="overflow: hidden; width: 100%; height: 100%;" class="waves-effect waves-block waves-light">
						<img class="activator" src="{{ url($article->image) }}">
					</div>
					<a data-clipboard-text="{{ $articleTargetUrl }}"
					   onclick="SynthesisCmsJsUtils.showToast('{!! trans('Hydrogen::hydrogen.options_modal_toast_link_copied') !!}', 2000)"
					   style="z-index: 2;" data-position="top" data-delay="50"
					   data-tooltip="{{ trans('Hydrogen::hydrogen.options_modal_btn_copy_link') }}"
					   class="tooltipped copylink-{{ $hydrogenUid }}-{{ $key }} btn-floating halfway-fab waves-effect waves-light {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}">
						<i class="material-icons">insert_link</i>
					</a>
					<script>
                        new Clipboard(".copylink-{{ $hydrogenUid }}-{{ $key }}");
					</script>
				</div>
				<div class="card-reveal">
					<span class="card-title col s12">
						<span class="truncate col s10">{{ $article->title }}</span>
						<i class="col s1 material-icons {{ $synthesiscmsMainColor }}-text right">close</i>
						<a href="{{ $articleTargetUrl }}">
							<i class="col s1 material-icons {{ $synthesiscmsMainColor }}-text right">open_in_new</i>
						</a>
					</span>
					<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"
						 style="margin-top: 5px; margin-bottom: 10px;"></div>
					{!! $article->description !!}
					@if(strlen(trim($article->description)) == 0)
						. . .
					@endif
				</div>
			@else
				<div class="card-title">
					<div class="col s12" style="margin-top: 10px;">
						<div class="col s10 m10 l10">
							<p class="truncate" style="margin-bottom: 0px; margin-top: 0px;">
								&nbsp;&nbsp;{{ $article->title }}
							</p>
						</div>
						<div class="col s2 m2 l2">
							<a href="{{ $articleTargetUrl }}"><i
										class="material-icons {{ $synthesiscmsMainColor }}-text">open_in_new</i></a>
						</div>
					</div>
				</div>
			@endif
			<div class="card-content"
				 @if(!$article->hasImage) style="padding-top: 5px !important; padding-bottom: 15px !important; overflow: hidden;" @endif>
				@if($article->hasImage)
					<div>
						<span class="card-title activator col s12" style="text-align: left;">
							{{ $article->title }}
							<i class="material-icons right">more_vert</i>
						</span>
						<a style="display: inline-block" href="{{ $articleTargetUrl }}"
						   class="synthesis-cool-link {{ $synthesiscmsMainColor }}-text">
							{{ trans("Hydrogen::hydrogen.article_card_link_read") }}
						</a>
					</div>
				@else
					<div style="max-height: 400px;">
						<div class="divider {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }} col s12"
							 style="margin-top: 5px; margin-bottom: 10px;"></div>
						{!! $article->description !!}
						@if(strlen(trim($article->description)) == 0)
							. . .
						@endif
					</div>
				@endif
			</div>
		</div>
	</div>
@endforeach
