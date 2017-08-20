<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PatchNitrogenItemsAddColorColumn extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('nitrogen_items', function (Blueprint $table) {
			$table->string('color')->default('#26a69a');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('nitrogen_items', function (Blueprint $table) {
			$table->dropColumn('color');
		});
	}
}
