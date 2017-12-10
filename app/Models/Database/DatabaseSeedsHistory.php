<?php

namespace App\Models\Database;

use Illuminate\Database\Eloquent\Model;

class DatabaseSeedsHistory extends Model
{

	public $timestamps = true;
	protected $fillable = ['className'];
	protected $table = 'synthesiscms_seeds_history';

	public static function seedIfNotAlreadySeeded($class, $seederRef, $echoLog)
	{
		$ret = false;
		if (self::checkIfAlreadySeeded($class)) {
			if ($echoLog) {
				echo("Not seeding " . $class . ", because it has already been seeded." . PHP_EOL);
			}
		} else {
			$seederRef->call($class);
			self::handleSeeded($class);
			$ret = true;
		}
		return $ret;
	}

	public static function checkIfAlreadySeeded($className)
	{
		return self::where(['className' => $className])->count();
	}

	public static function handleSeeded($className)
	{
		return self::create(['className' => $className]);
	}

}

?>
