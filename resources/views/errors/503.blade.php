@extends('layouts.error')

@section('title', trans('synthesiscms/errors.503_header'))

@section('body')
	<div class="section red lighten-2" style="min-height: 100vh;">
		<div class="col s12 row">
			<div class="col s12">
				<div class="container">
					<h2 class="white-text"><i class="material-icons large prefix center-on-small-only"
											  style="vertical-align: middle;">build</i>&nbsp;{{ trans('synthesiscms/errors.503_header') }}
					</h2>
					<h4 class="light red-text text-lighten-4 center-on-small-only">{{ trans('synthesiscms/errors.503_desc') }}</h4>
				</div>
			</div>
			<div class="col s12 white darken-1 z-depth-3" style="margin-top: 10px;">
				<div class="container" style="margin-top: 40px; margin-bottom: 50px;">
					<h2 class="header red-text text-lighten-2">{{ trans('synthesiscms/errors.503_desc2') }}</h2>
					<p class="flow-text caption">{{ trans('synthesiscms/errors.503_desc3') }}</p>
					<script>
                        function reload() {
                            var reloadIcon = document.querySelector('#reloadIcon');
                            reloadIcon.style.webkitTransform = 'translateZ(0px) rotateZ( ' + 1080 + 'deg )';
                            reloadIcon.style.MozTransform = 'translateZ(0px) rotateZ( ' + 1080 + 'deg )';
                            reloadIcon.style.transform = 'translateZ(0px) rotateZ( ' + 1080 + 'deg )';
                            // give the animation some time for the user to see it
                            setTimeout(function(){
                                location.reload();
							}, 2000);
                        }
					</script>
					<button onclick="reload();" id="reload" class="btn-large waves-effect waves-light">
						<i id="reloadIcon" class="material-icons white-text left"
						   style="transition: transform 2000ms;">
							refresh
						</i>
						&nbsp;{{ trans('synthesiscms/errors.refresh_btn') }}
					</button>
				</div>
			</div>
		</div>
	</div>
@endsection
