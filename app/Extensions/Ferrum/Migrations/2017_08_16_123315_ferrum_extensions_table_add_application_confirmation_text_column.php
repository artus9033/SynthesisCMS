<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FerrumExtensionsTableAddSubmitButtonColumn extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ferrum_extensions', function (Blueprint $table) {
			$table->longText('submitButtonText');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ferrum_extensions', function (Blueprint $table) {
			$table->dropColumn('submitButtonText');
		});
	}
}