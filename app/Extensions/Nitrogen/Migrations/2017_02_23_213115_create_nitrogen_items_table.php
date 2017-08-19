<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNitrogenItemsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('nitrogen_items', function (Blueprint $table) {
			$table->increments('id');
			$table->longText('image');
			$table->longText('title');
			$table->longText('content');
			$table->integer('slider')->default(1);
			$table->integer('parentOf')->default(0);
			$table->integer('before')->default(0);
			$table->longText('titleTextColor');
			$table->longText('contentTextColor');
			$table->integer('parentInstance');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('nitrogen_items');
	}
}
