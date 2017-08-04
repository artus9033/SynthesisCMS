<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSynthesiscmsExtensionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('synthesiscms_settings', function (Blueprint $table) {
			$table->longText('synthesiscms_installed_extensions');
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
			$table->dropColumn('synthesiscms_installed_extensions');
		});
	}
}
