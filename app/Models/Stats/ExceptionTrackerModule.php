<?php

namespace App\Models\Stats;

use Illuminate\Database\Eloquent\Model;

class ExceptionTrackerModule extends Model
{

	public $timestamps = false;
	protected $fillable = ['last_error'];
	protected $table = 'synthesiscms_exceptions_tracker_module';

	public static function findOrCreate($dateTimeString){
		$query = ExceptionTrackerModule::where(['id' => 1]);
		if($query->count()){
			return $query->first();
		}else{
			return ExceptionTrackerModule::create(['last_error' => $dateTimeString]);
		}
	}

	public static function getLastErrorDateTime()
	{
		return ExceptionTrackerModule::findOrCreate()->last_error;
	}

	public static function setLastErrorDateTime($dateTimeString)
	{
		$trackerModule = ExceptionTrackerModule::findOrCreate($dateTimeString);
		$trackerModule->last_error = $dateTimeString;
		$trackerModule->save();
	}

}

?>
