<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('synthesiscms_articles', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title')->default("SynthesisCMS Article Sample");
			$table->longText('description');
			$table->integer('articleCategory')->default(1);
			$table->string('image')->default('');
			$table->boolean('hasImage')->default(false);
			$table->string('cardSize')->default('');
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
		Schema::dropIfExists('synthesiscms_articles');
	}
}
