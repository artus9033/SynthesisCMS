<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

use Dotenv\Dotenv;

$app = new Illuminate\Foundation\Application(
	realpath(__DIR__ . '/../')
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

if (!file_exists(base_path('.env'))) {
	copy(base_path('.env.example'), base_path('.env'));
	if (!\App\Toolbox::isRunningInConsole()) {
		App\SynthesisCMS\API\Scripts\SynthesisArtisanBridge::artisanGenerateKey();
	}
}

$app->singleton(
	Illuminate\Contracts\Http\Kernel::class,
	App\Http\Kernel::class
);

$app->singleton(
	Illuminate\Contracts\Console\Kernel::class,
	App\Console\Kernel::class
);

$app->singleton(
	Illuminate\Contracts\Debug\ExceptionHandler::class,
	App\Exceptions\Handler::class
);

$res = Array(true, '');
$dotenv = method_exists('\Dotenv\Dotenv', "create") ? Dotenv::create(__DIR__ . '/../') : new Dotenv(__DIR__ . "/../");
$dotenv->load();
mysqli_report(MYSQLI_REPORT_STRICT);
$bCont = true;
try {
	@($sqli = new mysqli(getenv('DB_HOST'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv('DB_DATABASE'), getenv('DB_PORT')));
} catch (Exception $e) {
	$res = Array(false, $e->getMessage());
	$bCont = false;
}

if($bCont){
	try {
		$result = $sqli->query("SHOW TABLES LIKE '" . getenv('DB_PREFIX') . "_" . \App\Models\Settings\Settings::getTableName() . "'");
		if (mysqli_num_rows($result) == 0) {
			$res = Array(false, "Cannot find SynthesisCMS settings table.");
		}
	} catch (Exception $e) {
		$res = Array(false,$e->getMessage());
	}
}

if ($app->runningInConsole()) {
	if($res[0]){
		$app->singleton('synthesiscmsActiveSettingsInstance', function () {
			return \App\Models\Settings\Settings::where('active', true)->first();
		});
		$app->singleton('synthesiscmsSettingsTableError', function () {
			return false;
		});
	}else{
		$app->singleton('synthesiscmsSettingsTableError', function () {
			return true;
		});
		echo("Error bootstrapping SynthesisCMS: " . $res[1] . PHP_EOL);
		echo("Anyway, continuing, because SynthesisCMS is running in console. Setting the settings database error constant to true." . PHP_EOL);
		error_log($res[1]);
	}
} else {
	if($res[0]){
		$app->singleton('synthesiscmsActiveSettingsInstance', function () {
			return \App\Models\Settings\Settings::where('active', true)->first();
		});
		$app->singleton('synthesiscmsSettingsTableError', function () {
			return false;
		});
	}else{
		$app->singleton('synthesiscmsSettingsTableError', function () {
			return true;
		});
		echo("Error bootstrapping SynthesisCMS: " . $res[1] . PHP_EOL);
		echo("Please contact the site administrator for help (P.S. Dear admin, everything You need to know to fix this error is in the error log. Probably you forgot to run db migrations)" . PHP_EOL);
		error_log($res[1]);
		exit;
	}
}

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
