<?php

namespace App\SynthesisCMS\API\Scripts;

use App\Toolbox;

class SynthesisNodeBridge
{

	static function executeNpmCmd($npmCommand)
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::execTimeLimitOverride();
		self::checkAndFixNodejsInstallation();
		self::checkAndFixNodejsModulesInstallation();
		return self::_executeNpmCommand($npmCommand);
	}

	static function checkNodejsInstallationIsProper()
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::execTimeLimitOverride();
		return file_exists(base_path('/vendor/nodejs/nodejs/node.exe'));
	}

	static function checkAndFixNodejsInstallation()
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		$problem = false;
		self::execTimeLimitOverride();
		if (!self::checkNodejsInstallationIsProper()) {
			self::_fixNodejsInstallation();
			$problem = true;
		}
		return $problem;
	}

	static function checkAndFixNodejsModulesInstallation(){
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		if(file_exists(base_path('node_modules'))){
			if(Toolbox::isDirectoryEmpty(base_path('node_modules'))){
				self::_installNodejsModules();
					return true;
			}
		}else{
			self::_installNodejsModules();
			return true;
		}
		return false;
	}

	static function installNodejsModules(){
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::checkAndFixNodejsInstallation();
		return self::_installNodejsModules();
	}

	static function nukeNodeModulesDir(){
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::checkAndFixNodejsInstallation();
		return self::_executeNodeCommand("rimrafExecutor.js node_modules &");
	}

	static function executeNodeCmd($nodeCmd){
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::checkAndFixNodejsInstallation();
		self::checkAndFixNodejsModulesInstallation();
		return self::_executeNodeCommand($nodeCmd);
	}

	private static function execTimeLimitOverride()
	{
		set_time_limit(0);
	}

	private static function _fixNodejsInstallation()
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		self::execTimeLimitOverride();
		SynthesisComposerBridge::executeComposerPharCmd("run-script download-nodejs");
		self::_installNodejsModules();
	}

	private static function _executeNpmCommand($npmCommand)
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		$dirBkp = getcwd();
		chdir(base_path());
		if (windows_os()) {
			$npm = base_path('vendor\bin\npm.bat');
		} else {
			$npm = base_path('vendor\bin\npm');
		}
		$cmd = escapeshellarg($npm) . " " . $npmCommand;
		$ret = shell_exec($cmd);
		chdir($dirBkp);
		return $ret;
	}

	private static function _executeNodeCommand($nodeCommand)
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		$dirBkp = getcwd();
		chdir(base_path());
		if (windows_os()) {
			$node = base_path('vendor\bin\node.bat');
		} else {
			$node = base_path('vendor\bin\node');
		}
		$cmd = escapeshellarg($node) . " " . $nodeCommand;
		$ret = shell_exec($cmd);
		chdir($dirBkp);
		return $ret;
	}

	private static function _installNodejsModules()
	{
		if(!Toolbox::isFunctionEnabled("shell_exec")){
			return "shell_exec() is not enabled!";
		}
		return self::_executeNpmCommand("install");
	}
}

?>
