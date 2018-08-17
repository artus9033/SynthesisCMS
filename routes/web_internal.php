<?php

foreach (glob(public_path() . '/*', GLOB_ONLYDIR) as $filename) {
	Route::any('/' . basename($filename) . '/{anything?}', function($anything = ""){}); //this only holds the route for the synthesis route checker to say it's occupied
}

?>
