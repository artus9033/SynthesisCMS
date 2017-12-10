<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PatchSettingsTableAddForceHttps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('synthesiscms_settings', function (Blueprint $table) {
			$table->boolean('force_https')->default(false);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('synthesiscms_settings', function (Blueprint $table) {
			$table->dropColumn('force_https');
		});
    }
}
