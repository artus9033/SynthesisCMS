<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHydrogenExtensionsTable extends Migration
{
	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{
		Schema::create('hydrogen_extensions', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('molecule')->default(1);
			$table->integer('list_column_count')->default(2);
			$table->integer('articles_on_single_page')->default(14);
			$table->boolean('showHeader')->default(true);
			$table->integer('default_sorting_type')->default(1);
			$table->integer('default_sorting_direction')->default(1);
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
		Schema::dropIfExists('hydrogen_extensions');
	}
}
