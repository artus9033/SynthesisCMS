<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
		  $table->string('slug');
		  $table->string('module');
		  $table->string('page_title')->default("SynthesisCMS Sample Title");
		  $table->string('page_content')->default("SynthesisCMS Sample Content: Lorem ipsum sit dolor amet...");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
