<?php

namespace App\Http\Middleware\SynthesisCMS;

use Closure;
use Dotenv\Dotenv;

class CheckDatabaseConnectionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $dotenv = Dotenv::create(__DIR__ . '/../../../../');
        $dotenv->load();
        mysqli_report(MYSQLI_REPORT_STRICT);

        try {
            @(new \mysqli(getenv('DB_HOST'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv('DB_DATABASE'), getenv('DB_PORT')));
        } catch (Exception $e) {
            echo ("Cannot connect to database. Please contact the site administrator for help (P.S. Dear admin, everything You need to know to fix this error is in the error log).");
            error_log(utf8_encode($e->getMessage()));
            $synthesisBootstrapErrorLogFile = __DIR__ . '/../../storage/logs/synthesiscms-bootstrap-error.log';
            $message = Carbon::now()->toDateTimeString() . " : `" . utf8_encode($e->getMessage()) . "`. This error means a problem with Your database connection. Please check your .env file configuration.";
            if (file_exists($synthesisBootstrapErrorLogFile)) {
                $fh = fopen($synthesisBootstrapErrorLogFile, 'a');
                fwrite($fh, $message . "\n");
            } else {
                $fh = fopen($synthesisBootstrapErrorLogFile, 'w');
                fwrite($fh, $message . "\n");
            }
            fclose($fh);
            exit;
        }

        return $next($request);
    }
}
