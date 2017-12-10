<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PatchSettingsTableAddSiteEnabled extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('synthesiscms_settings', function (Blueprint $table) {
			$table->boolean('site_enabled')->default(true);
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
			$table->dropColumn('site_enabled');
		});
    }
}
