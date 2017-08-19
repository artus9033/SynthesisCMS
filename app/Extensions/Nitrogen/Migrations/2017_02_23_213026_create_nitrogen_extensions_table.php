<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
			$table->longText('assignedPages');
			$table->boolean('autoplay')->default(true);
			$table->boolean('buttons')->default(true);
			$table->integer('interval')->default(7000);
			$table->longText('title');
			$table->boolean('assignedToAllPages')->default(false);
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
