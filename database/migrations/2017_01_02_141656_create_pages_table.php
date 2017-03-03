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
        Schema::create('synthesiscms_pages', function (Blueprint $table) {
            $table->increments('id');
		  $table->longText('slug');
		  $table->longText('extension');
		  $table->longText('page_title');
		  $table->longText('page_header');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('synthesiscms_pages');
    }
}
