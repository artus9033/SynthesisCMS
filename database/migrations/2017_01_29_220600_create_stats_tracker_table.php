<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatsTrackerTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('synthesiscms_stats_tracker', function (Blueprint $table) {
			$table->increments('id');
			$table->string('ip');
			$table->string('url');
			$table->integer('hits')->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('synthesiscms_stats_tracker');
	}
}
