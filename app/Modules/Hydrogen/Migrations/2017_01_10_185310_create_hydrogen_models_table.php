<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHydrogenModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hydrogen_models', function (Blueprint $table) {
            $table->increments('id');
		  $table->string('title')->default("Hydrogen Sample Title");
		  $table->string('content')->default("Hydrogen Sample Content: Lorem ipsum sit dolor amet...");
		  $table->string('image')->default("http://mannaforlifeblog.com/wp-content/uploads/2014/04/Electrik_bulb2-586x349.jpg");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hydrogen_models');
    }
}
