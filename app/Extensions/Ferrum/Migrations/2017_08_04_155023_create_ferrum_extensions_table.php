<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFerrumExtensionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ferrum_extensions', function (Blueprint $table) {
			$table->increments('id');
			$table->longText('formInJson');
			$table->boolean('showHeader')->default(true);
			$table->longText('applicationsInJson');
			$table->dateTime('applicationsCloseDateTime');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('ferrum_extensions');
	}
}
