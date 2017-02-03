<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
		  $table->integer('type')->default('4');
		  $table->integer('category')->default('3');
		  $table->longtext('title');
		  $table->longtext('href');
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
