<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSynthesicmsArticleSynthesiscmsTagPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('synthesiscms_article_synthesiscms_tag', function (Blueprint $table) {
            $table->integer('synthesiscms_article_id')->unsigned()->index();
            $table->foreign('synthesiscms_article_id')->references('id')->on('synthesiscms_articles')->onDelete('cascade');
            $table->integer('synthesiscms_tag_id')->unsigned()->index();
            $table->foreign('synthesiscms_tag_id')->references('id')->on('synthesiscms_tags')->onDelete('cascade');
            $table->primary(['synthesiscms_article_id', 'synthesiscms_tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('synthesiscms_article_synthesiscms_tag');
    }
}
