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

	public function getLastUpdateDateTime()
	{
		return $this->last_update;
	}

	public function setLastUpdateDateTime($dateTimeString)
	{
		$this->last_update = $dateTimeString;
		$this->save();
	}

}

?>
