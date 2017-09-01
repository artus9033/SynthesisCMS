<?php

namespace App\SynthesisCMS\API\Scripts;

class SynthesisArtisanBridge
{

	static function artisanStorageLink()
	{
		self::execTimeLimitOverride();
		return self::executeArtisanCmd("storage:link");
	}

	private static function execTimeLimitOverride()
	{
		set_time_limit(0);
	}

	static function executeArtisanCmd($composerCommand)
	{
		self::execTimeLimitOverride();
		$cmd = "php " . base_path('artisan') . " " . $composerCommand;
		return shell_exec($cmd);
	}

	static function artisanCacheClear()
	{
		self::execTimeLimitOverride();
		return self::executeArtisanCmd("cache:clear");
	}

	static function artisanClearCompiled()
	{
		self::execTimeLimitOverride();
		return self::executeArtisanCmd("clear-compiled");
	}
	
	static function artisanConfigClear()
	{
		self::execTimeLimitOverride();
		return self::executeArtisanCmd("config:clear");
	}

	static function artisanRouteClear()
	{
		self::execTimeLimitOverride();
		return self::executeArtisanCmd("route:clear");
	}

	static function artisanViewClear()
	{
		self::execTimeLimitOverride();
		return self::executeArtisanCmd("view:clear");
	}

	static function artisanRouteCache()
	{
		self::execTimeLimitOverride();
		return self::executeArtisanCmd("route:cache");
	}

	static function artisanConfigCache()
	{
		self::execTimeLimitOverride();
		return self::executeArtisanCmd("config:cache");
	}

	static function artisanOptimize()
	{
		self::execTimeLimitOverride();
		return self::executeArtisanCmd("optimize");
	}

}

?>
