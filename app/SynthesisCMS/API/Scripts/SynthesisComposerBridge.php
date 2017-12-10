<?php

namespace App\SynthesisCMS\API\Scripts;

use App\Toolbox;

class SynthesisComposerBridge
{

	static function composerDumpAutoload()
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::execTimeLimitOverride();
		return self::executeComposerPharCmd("dump-autoload");
	}

	private static function execTimeLimitOverride()
	{
		set_time_limit(0);
	}

	static function executeComposerPharCmd($composerCommand)
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::execTimeLimitOverride();
		self::checkAndFixComposerPharInstallation();
		$cmd = "php " . base_path('composer.phar') . " " . $composerCommand;
		return shell_exec($cmd);
	}

	static function checkAndFixComposerPharInstallation()
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::execTimeLimitOverride();
		if (!self::checkComposerPharInstallationIsProper()) {
			self::_fixComposerPharInstallation();
			return true;
		} else {
			return false;
		}
	}

	static function checkComposerPharInstallationIsProper()
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::execTimeLimitOverride();
		return file_exists(base_path('composer.phar'));
	}

	private static function _fixComposerPharInstallation()
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::execTimeLimitOverride();
		copy("http://getcomposer.org/composer.phar", base_path('composer.phar'));
	}
}

?>
