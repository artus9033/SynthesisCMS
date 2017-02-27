<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
		  $table->longText('buttonLink');
		  $table->longText('buttonText');
		  $table->longText('buttonWavesColor');
		  $table->longText('buttonColor');
		  $table->longText('buttonClass');
		  $table->boolean('hasButton')->default(false);
		  $table->longText('title');
		  $table->longText('content');
		  $table->integer('type')->default(1);
		  $table->integer('slider')->default(1);
		  $table->integer('parentOf')->default(0);
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
        Schema::dropIfExists('nitrogen_items');
    }
}
