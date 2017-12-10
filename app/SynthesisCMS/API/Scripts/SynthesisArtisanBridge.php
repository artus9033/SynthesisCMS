<?php

namespace App\SynthesisCMS\API\Scripts;

use App\Toolbox;

class SynthesisArtisanBridge
{

	static function artisanGenerateKey(){
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::execTimeLimitOverride();
		return self::executeArtisanCmd("key:generate");
	}

	static function artisanStorageLink()
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::execTimeLimitOverride();
		return self::executeArtisanCmd("storage:link");
	}

	private static function execTimeLimitOverride()
	{
		set_time_limit(0);
	}

	static function executeArtisanCmd($composerCommand)
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::execTimeLimitOverride();
		$cmd = "php " . base_path('artisan') . " " . $composerCommand;
		return shell_exec($cmd);
	}

	static function artisanCacheClear()
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::execTimeLimitOverride();
		return self::executeArtisanCmd("cache:clear");
	}

	static function artisanClearCompiled()
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::execTimeLimitOverride();
		return self::executeArtisanCmd("clear-compiled");
	}
	
	static function artisanConfigClear()
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::execTimeLimitOverride();
		return self::executeArtisanCmd("config:clear");
	}

	static function artisanRouteClear()
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::execTimeLimitOverride();
		return self::executeArtisanCmd("route:clear");
	}

	static function artisanViewClear()
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::execTimeLimitOverride();
		return self::executeArtisanCmd("view:clear");
	}

	static function artisanRouteCache()
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::execTimeLimitOverride();
		return self::executeArtisanCmd("route:cache");
	}

	static function artisanConfigCache()
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::execTimeLimitOverride();
		return self::executeArtisanCmd("config:cache");
	}

	static function artisanOptimize()
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::execTimeLimitOverride();
		return self::executeArtisanCmd("optimize");
	}

}

?>
