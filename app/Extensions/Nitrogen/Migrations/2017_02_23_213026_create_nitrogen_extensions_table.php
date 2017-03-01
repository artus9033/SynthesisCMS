<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNitrogenExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nitrogen_extensions', function (Blueprint $table) {
            $table->increments('id');
		  $table->boolean('enabled')->default(true);
		  $table->longText('buttonTextColor');
		  $table->longText('buttonLink');
		  $table->longText('buttonText');
		  $table->longText('buttonWavesColor');
		  $table->longText('buttonColor');
		  $table->longText('buttonClass');
		  $table->boolean('hasButton')->default(false);
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
        Schema::dropIfExists('nitrogen_extensions');
    }
}
