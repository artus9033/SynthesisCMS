<?php

/* Routes tracked by StatsTracker & with all other general middleware,
 * almost always they are added by extensions & applets.
 * This file is only maintained in case it was be needed in future
 */

Route::get('/_debugbar/assets/stylesheets', [
    'as' => 'debugbar-css',
    'uses' => '\Barryvdh\Debugbar\Controllers\AssetController@css'
]);

Route::get('/_debugbar/assets/javascript', [
    'as' => 'debugbar-js',
    'uses' => '\Barryvdh\Debugbar\Controllers\AssetController@js'
]);

?>
