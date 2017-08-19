<?php

namespace App\Models\Stats;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tracker extends Model
{

	public $timestamps = false;
	protected $fillable = ['ip', 'url', 'date', 'hits'];
	protected $table = 'synthesiscms_stats_tracker';

	public static function hit()
	{
		$query = Tracker::where(['ip' => $_SERVER['REMOTE_ADDR'], 'url' => \Request::path(), 'date' => Carbon::now()->toDateString()]);
		if ($query->count()) {
			$tracker = $query->first();
			$tracker->hits++;
			$tracker->save();
		} else {
			$tracker = Tracker::create(['ip' => $_SERVER['REMOTE_ADDR'], 'url' => \Request::path(), 'date' => Carbon::now()->toDateString()]);
		}
	}

}

?>
