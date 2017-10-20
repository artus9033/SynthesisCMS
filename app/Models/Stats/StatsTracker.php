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
		$statsTrackerInstance = StatsTrackerModule::findOrCreate();
		$statsTrackerInstance->setLastUpdateDateTime(Carbon::now()->toDateTimeString());
		$tracker = StatsTracker::firstOrNew([
			'ip' => $_SERVER['REMOTE_ADDR'],
			'url' => \Request::path(),
			'date' => Carbon::now()->toDateString()
		]);
		$tracker->hits++;
		$tracker->save();
	}

}

?>
