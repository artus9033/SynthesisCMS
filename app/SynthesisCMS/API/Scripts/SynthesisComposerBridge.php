<?php

namespace App\SynthesisCMS\API\Scripts;

class SynthesisComposerBridge
{

	static function composerDumpAutoload()
	{
		self::execTimeLimitOverride();
		return self::executeComposerPharCmd("dump-autoload");
	}

	private static function execTimeLimitOverride()
	{
		set_time_limit(0);
	}

	static function executeComposerPharCmd($composerCommand)
	{
		self::execTimeLimitOverride();
		self::checkAndFixComposerPharInstallation();
		$cmd = "php " . base_path('composer.phar') . " " . $composerCommand;
		return shell_exec($cmd);
	}

	static function checkAndFixComposerPharInstallation()
	{
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
		self::execTimeLimitOverride();
		return file_exists(base_path('composer.phar'));
	}

	private static function _fixComposerPharInstallation()
	{
		self::execTimeLimitOverride();
		copy("http://getcomposer.org/composer.phar", base_path('composer.phar'));
	}
}

?>
