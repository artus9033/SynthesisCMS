<div class="progress" style="margin: unset !important;">
	<div class="determinate" id="nitrogen-progress" style="width: 0%"></div>
</div>

<style>
	.nitrogen-left {
		left: 0px;
	}

	.nitrogen-right {
		right: 0px;
	}

	.nitrogen-nav-button {
		position: fixed;
		opacity: 0.75;
		vertical-align: middle;
		top: 45%;
		z-index: 99999;
	}

	.nitrogen-nav-button:hover {
		opacity: 1;
	}
</style>

<div id="nitrogen-slider" class="carousel carousel-slider center" data-indicators="true">
	@if($model->buttons)
		<div onclick="nitrogen_left();"
			 class="waves-effect waves-light btn-floating {{ $synthesiscmsMainColor }} nitrogen-nav-button nitrogen-left">
			<i class="material-icons white-text">chevron_left</i></div>
		<div onclick="nitrogen_right();"
			 class="waves-effect waves-light btn-floating {{ $synthesiscmsMainColor }} nitrogen-nav-button nitrogen-right">
			<i class="material-icons white-text">chevron_right</i></div>
	@endif
	{!! $kernel->getSliderItems($slug, $nr) !!}
</div>
<script>
    var nitrogen_timer_max = {{ $model->interval }};
    var nitrogen_slider = $('#nitrogen-slider');
    var nitrogen_progress = $('#nitrogen-progress');

    function nitrogen_left() {
        nitrogen_slider.carousel('prev');
        nitrogen_progress.css('width', '0px');
        nitrogen_autoplay_pause();
    }

    function nitrogen_right() {
        nitrogen_slider.carousel('next');
        nitrogen_progress.css('width', '0px');
        nitrogen_autoplay_pause();
    }

    function nitrogen_autoplay() {
        if ({{ $model->autoplay }}) {
            nitrogen_progress.css('width', '0px');
            setTimeout(function () {
                nitrogen_progress.animate({width: nitrogen_progress.parent().width()}, {
                    duration: nitrogen_timer_max,
                    complete: function () {
                        nitrogen_autoplay();
                    }
                });
            }, 1000);
            nitrogen_slider.carousel('next');
        }
    }

    function nitrogen_autoplay_pause() {
        nitrogen_progress.stop(true, false);
    }

    function nitrogen_autoplay_resume() {
        var mDurationLeft = nitrogen_timer_max - (nitrogen_timer_max * (nitrogen_progress.width() / nitrogen_progress.parent().width()));
        nitrogen_progress.animate({width: nitrogen_progress.parent().width()}, {
            duration: mDurationLeft,
            complete: function () {
                nitrogen_autoplay();
            }
        });
    }

    nitrogen_slider.hover(
        function () {
            nitrogen_autoplay_pause();
        }, function () {
            nitrogen_autoplay_resume();
        }
    );

    $(document).ready(function () {
        $('#nitrogen-slider').carousel({fullWidth: true, indicators: true});
        nitrogen_autoplay();
    });
</script>
