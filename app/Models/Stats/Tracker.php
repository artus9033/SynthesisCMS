<?php

namespace App\Models\Stats;

use Illuminate\Database\Eloquent\Model;

class Tracker extends Model {

    protected $fillable = [ 'ip', 'url', 'hits' ];

    protected $table = 'synthesiscms_stats_tracker';

    public $timestamps = false;

    public static function hit(){
	    if(Tracker::where(['ip' => $_SERVER['REMOTE_ADDR'], 'url' => \Request::path()])->count()){
		    $tracker = Tracker::where(['ip' => $_SERVER['REMOTE_ADDR'], 'url' => \Request::path()])->first();
		    $tracker->hits++;
		    $tracker->save();
	    }else{
		    $tracker = Tracker::create(['ip' => $_SERVER['REMOTE_ADDR'], 'url' => \Request::path()]);
	    }
    }

}
?>
