<?php

namespace App\Models\Installer;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class InstallerModel extends Model
{
	public $timestamps = false;
	protected $fillable = array('was_ever_installed', 'first_installation_finished');
	protected $table = 'synthesiscms_installer';

	public static function wasEverInstalled()
	{
		return self::getFromActive('was_ever_installed');
	}

	public static function installationSuccess(){
		self::getActiveInstance()->was_ever_installed = true;
		self::getActiveInstance()->first_installation_finished = Carbon::now()->toDateTimeString();
		//TODO: report successful installation to SynthesisCMS services
	}

	public static function getFromActive($field)
	{
		return self::getActiveInstance()->$field;
	}

	public static function getActiveInstance()
	{
		if(self::all()->count()){
			return self::first();
		}else{
			return self::create();
		}
	}
}
