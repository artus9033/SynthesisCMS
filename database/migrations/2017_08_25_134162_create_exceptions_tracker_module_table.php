<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExceptionsTrackerModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('synthesiscms_exceptions_tracker_module', function (Blueprint $table) {
			$table->increments('id');
			$table->dateTime('last_error');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('synthesiscms_exceptions_tracker_module');
    }
}
