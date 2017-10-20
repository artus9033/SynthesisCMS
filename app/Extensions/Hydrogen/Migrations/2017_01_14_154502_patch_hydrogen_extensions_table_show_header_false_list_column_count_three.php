<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PatchHydrogenExtensionsTableShowHeaderFalseListColumnCountThree extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('hydrogen_extensions', function (Blueprint $table) {
			$table->integer('list_column_count')->default(3)->change();
			$table->boolean('showHeader')->default(false)->change();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('hydrogen_extensions');
	}
}
