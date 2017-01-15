<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoleculesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('molecules', function (Blueprint $table) {
            $table->increments('id');
 		  $table->string('title')->default("SynthesisCMS Molecule Sample");
 		  $table->string('description')->default("SynthesisCMS Molecule Sample Description: Lorem ipsum sit dolor amet...");
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
        Schema::dropIfExists('molecules');
    }
}
