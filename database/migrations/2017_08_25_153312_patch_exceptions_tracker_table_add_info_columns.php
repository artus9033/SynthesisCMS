<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PatchExceptionsTrackerTableAddInfoColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('synthesiscms_exceptions_tracker', function (Blueprint $table) {
			$table->longText('cms_root');
			$table->longText('os_info');
			$table->longText('cms_info');
			$table->longText('php_info');
			$table->longText('php_disabled_functions');
			$table->longText('php_modules');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('synthesiscms_exceptions_tracker', function (Blueprint $table) {
			$table->dropColumn('cms_root');
			$table->dropColumn('os_info');
			$table->dropColumn('cms_info');
			$table->dropColumn('php_info');
			$table->dropColumn('php_disabled_functions');
			$table->dropColumn('php_modules');
		});
    }
}
