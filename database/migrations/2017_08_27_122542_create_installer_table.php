<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstallerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('synthesiscms_installer', function (Blueprint $table) {
			$table->increments('id');
			$table->boolean('was_ever_installed')->default(false);
			$table->dateTime('first_installation_finished')->default(\Carbon\Carbon::now()->toDateTimeString());
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('synthesiscms_installer');
    }
}
