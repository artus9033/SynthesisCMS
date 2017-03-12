<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoronExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boron_extensions', function (Blueprint $table) {
            $table->increments('id');
		  $table->boolean('enabled')->default(true);
		  $table->longText('url');
		  $table->longText('facebookAppId');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boron_extensions');
    }
}
