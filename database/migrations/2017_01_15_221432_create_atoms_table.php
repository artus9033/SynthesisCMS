<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('atoms', function (Blueprint $table) {
            $table->increments('id');
 		  $table->string('title')->default("SynthesisCMS Atom Sample");
 		  $table->string('description')->default("SynthesisCMS Atom Sample Description: Lorem ipsum sit dolor amet...");
		  $table->integer('molecule')->default(0);
		  $table->string('image')->default("http://web.chem.ucla.edu/~harding/IGOC/P/pinner_reaction01.png");
		  $table->string('imageSourceType')->default("web");
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
        Schema::dropIfExists('atoms');
    }
}
