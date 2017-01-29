<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
		  $table->string('date');
		  $table->string('visit_time');
		  $table->integer('hits');
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
