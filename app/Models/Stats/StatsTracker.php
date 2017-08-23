<?php

namespace App\Models\Stats;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StatsTracker extends Model
{

	public $timestamps = false;
	protected $fillable = ['ip', 'url', 'date', 'hits'];
	protected $table = 'synthesiscms_stats_tracker';

	public static function hit()
	{
		StatsTrackerModule::setLastUpdateDateTime(Carbon::now()->toDateTimeString());
		$query = StatsTracker::where(['ip' => $_SERVER['REMOTE_ADDR'], 'url' => \Request::path(), 'date' => Carbon::now()->toDateString()]);
		if ($query->count()) {
			$tracker = $query->first();
			$tracker->hits++;
			$tracker->save();
		} else {
			StatsTracker::create(['ip' => $_SERVER['REMOTE_ADDR'], 'url' => \Request::path(), 'date' => Carbon::now()->toDateString()]);
		}
	}

}

?>
