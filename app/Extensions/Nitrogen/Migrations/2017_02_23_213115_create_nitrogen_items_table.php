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
		  $table->longText('image');
		  $table->longText('title');
		  $table->longText('content');
		  $table->integer('type')->default(1);
		  $table->integer('slider')->default(1);
		  $table->integer('parentOf')->default(0);
		  $table->integer('before')->default(0);
		  $table->longText('titleTextColor');
		  $table->longText('contentTextColor');
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
