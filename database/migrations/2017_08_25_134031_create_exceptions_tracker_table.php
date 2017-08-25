<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExceptionsTrackerTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('synthesiscms_exceptions_tracker', function (Blueprint $table) {
			$table->increments('id');
			$table->string('ip');
			$table->string('url');
			$table->date('date')->default(\Carbon\Carbon::now()->toDateString());
			$table->integer('code')->default(500);
			$table->longText('file');
			$table->longText('message');
			$table->longText('stack_trace');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('synthesiscms_exceptions_tracker');
	}
}
