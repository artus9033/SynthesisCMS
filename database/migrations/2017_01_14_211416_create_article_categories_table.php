<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleCategoriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article_categories', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title')->default("SynthesisCMS ArticleCategory Sample");
			$table->string('description')->default("SynthesisCMS ArticleCategory Sample Description: Lorem ipsum sit dolor amet...");
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
		Schema::dropIfExists('articleCategories');
	}
}
