<?php

namespace App\Models\Stats;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Probe\ProviderFactory;
use App\Toolbox;

class ExceptionTracker extends Model
{

	public $timestamps = false;
	protected $fillable = ['ip', 'url', 'date', 'code', 'file', 'message', 'stack_trace', 'cms_root', 'os_info', 'cms_info', 'php_info', 'php_disabled_functions', 'php_modules'];
	protected $table = 'synthesiscms_exceptions_tracker';

	public static function saveException($devModeEnabled, $code, $file, $message, $stackTrace, $cms_root)
	{
		ExceptionTrackerModule::setLastErrorDateTime(Carbon::now()->toDateTimeString());
		$phpInfoProvider = ProviderFactory::create();
		// don't check os details if shell_exec() is blocked (like on some shared hostings)
		if(!Toolbox::isFunctionEnabled('shell_exec')){
			$os_info = $php_disabled_functions_imp = $php_disabled_functions = $php_modules = $php_modules_imp = "Error initializing Probe\ProviderFactory (probably shell_exec is disabled?)";
			$os_info .= "shell_exec() has been blocked. Please review Your php configuration.";
			if($devModeEnabled){
				echo("DEVMODE WARNING: ExceptionTracker could not determine system information. Probe\ProviderFactory error: shell_exec() has been blocked. Please review Your php configuration.");
			}
		}else{
			if (extension_loaded('COM_DOT_NET') || (stripos(PHP_OS, 'win') !== 0)) { // If NOT windows OR COM_DOT_NET extension is loaded
				$os_info = 'Type: ' . $phpInfoProvider->getOsType() . '; release: ' . $phpInfoProvider->getOsRelease() . '; arch:' . $phpInfoProvider->getArchitecture() . '; kernel ver:' . $phpInfoProvider->getOsKernelVersion();
			} else {
				$os_info = "Error: OS is Windows, but to read more info the COM_DOT_NET extension is needed, but it is not loaded!";
			}
			$php_disabled_functions_imp = implode(',', $phpInfoProvider->getPhpDisabledFunctions());
			$php_disabled_functions = (strlen($php_disabled_functions_imp) ? $php_disabled_functions_imp : '- NONE -');
			$php_modules_imp = implode(',', $phpInfoProvider->getPhpModules());
			$php_modules = (strlen($php_modules_imp) ? $php_modules_imp : '- NONE -');
		}
		ExceptionTracker::create([
			'ip' => $_SERVER['REMOTE_ADDR'],
			'url' => \Request::path(),
			'date' => Carbon::now()->toDateString(),
			'code' => $code,
			'file' => $file,
			'message' => $message,
			'stack_trace' => $stackTrace,
			'cms_root' => $cms_root,
			'os_info' => $os_info,
			'cms_info' => ('SynthesisCMS ver: ' . \App::version() . '; SynthesisMindstorm ver: '),//TODO: . \SynthesisMindstormBridge::version(),
			'php_info' => ('Version: ' . $phpInfoProvider->getPhpVersion() . '; sapi name: ' . $phpInfoProvider->getPhpSapiName()),
			'php_disabled_functions' => $php_disabled_functions,
			'php_modules' => $php_modules
		]);
	}
}

?>
