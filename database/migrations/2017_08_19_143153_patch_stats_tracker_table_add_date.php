<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PatchStatsTrackerTableAddDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('synthesiscms_stats_tracker', function (Blueprint $table) {
			$table->date('date')->default(\Carbon\Carbon::now()->toDateString());
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('synthesiscms_stats_tracker', function (Blueprint $table) {
			$table->dropColumn('date');
		});
    }
}
