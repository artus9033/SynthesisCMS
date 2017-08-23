<?php

namespace App\Models\Stats;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StatsTrackerModule extends Model
{

	public $timestamps = false;
	protected $fillable = ['last_update'];
	protected $table = 'synthesiscms_stats_tracker_module';

	public static function findOrCreate(){
		$query = StatsTrackerModule::where(['id' => 1]);
		if($query->count()){
			return $query->first();
		}else{
			return StatsTrackerModule::create(['last_update' => Carbon::now()->toDateTimeString()]);
		}
	}

	public static function getLastUpdateDateTime()
	{
		return StatsTrackerModule::findOrCreate()->last_update;
	}

	public static function setLastUpdateDateTime($dateTimeString)
	{
		$trackerModule = StatsTrackerModule::findOrCreate();
		$trackerModule->last_update = $dateTimeString;
		$trackerModule->save();
	}

}

?>
