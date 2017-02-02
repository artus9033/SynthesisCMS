@if($synthesiscmsPositionManager->getCustom('berylium', 'desktop-menu', Request::url()) != "")
<nav class="col s12 {{ $synthesiscmsMainColor }} darken-1 hide-on-med-and-down">
	<div class="nav-wrapper">
		<ul>
			{!! $synthesiscmsPositionManager->getCustom('berylium', 'desktop-menu', Request::url()) !!}
		</ul>
	</div>
</nav>
@endif
@if($synthesiscmsPositionManager->getCustom('berylium', 'mobile-menu', Request::url()) != "")
<ul id="berylium-mobile-menu" class="side-nav">
	{!! $synthesiscmsPositionManager->getCustom('berylium', 'mobile-menu', Request::url()) !!}
</ul>
@endif

<script>
$(document).ready(function(){
	$('.berylium-menu-button-collapse').sideNav({
      menuWidth: 500,
      edge: 'left',
      closeOnClick: true,
      draggable: true
    }
  );
});
</script>
