<?php

namespace App\SynthesisCMS\API\Scripts;

class SynthesisNodeBridge
{

	private static function execTimeLimitOverride()
	{
		set_time_limit(0);
	}

	static function executeNpmCmd($npmCommand)
	{
		self::execTimeLimitOverride();
		self::checkAndFixNodejsInstallation();
		return self::_executeNpmCommand($npmCommand);
	}

	static function checkNodejsInstallationIsProper()
	{
		self::execTimeLimitOverride();
		return file_exists(base_path('/vendor/nodejs/nodejs/node.exe'));
	}

	static function checkAndFixNodejsInstallation()
	{
		$problem = false;
		self::execTimeLimitOverride();
		if (!self::checkNodejsInstallationIsProper()) {
			self::_fixNodejsInstallation();
			$problem = true;
		}
		error_log(self::_executeNpmCommand("ls"));
		return $problem;
	}

	private static function _fixNodejsInstallation()
	{
		self::execTimeLimitOverride();
		SynthesisComposerBridge::executeComposerPharCmd("run-script download-nodejs");
	}

	private static function _executeNpmCommand($npmCommand){
		if (windows_os()) {
			$npm = base_path('/vendor/bin/npm.bat');
		} else {
			$npm = base_path('/vendor/bin/npm');
		}
		$cmd = escapeshellarg($npm) . " " . $npmCommand;
		return shell_exec($cmd);
	}
}

?>
