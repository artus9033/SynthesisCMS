<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeryliumItemsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('berylium_items', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('type')->default(4);
			$table->integer('category')->default(3);
			$table->longText('title');
			$table->longText('data');
			$table->integer('parentOf')->default(0);
			$table->integer('menu')->default(1);
			$table->integer('before')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('berylium_items');
	}
}
