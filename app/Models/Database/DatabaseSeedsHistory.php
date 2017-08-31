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
		if (self::checkIfAlreadyMigrated($class)) {
			if ($echoLog) {
				echo("Not seeding " . $class . ", because it has already been seeded." . PHP_EOL);
			}
		} else {
			$seederRef->call($class);
			self::handleMigrated($class);
			$ret = true;
		}
		return $ret;
	}

	public static function checkIfAlreadyMigrated($className)
	{
		return self::where(['className' => $className])->count();
	}

	public static function handleMigrated($className)
	{
		return self::create(['className' => $className]);
	}

}

?>
