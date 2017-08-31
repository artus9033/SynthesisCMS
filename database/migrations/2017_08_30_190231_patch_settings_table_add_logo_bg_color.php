<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PatchSettingsTableAddLogoBgColor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('synthesiscms_settings', function (Blueprint $table) {
			$table->longText('logo_background_color');
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
			$table->dropColumn('logo_background_color');
		});
    }
}
