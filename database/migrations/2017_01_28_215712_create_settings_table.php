<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('synthesiscms_settings', function (Blueprint $table) {
            $table->increments('id');
		  $table->string('header_title')->default("SynthesisCMS");
		  $table->string('tab_title')->default("SynthesisCMS");
		  $table->string('footer_copyright')->default("by artus9033");
		  $table->string('footer_more_links_bottom_text')->default("More Links");
		  $table->string('footer_more_links_bottom_href')->default("http://google.com");
		  $table->string('footer_links_text')->default("Some Useful Links:");
		  $table->longText('footer_links_content');
		  $table->longText('footer_header');
		  $table->longText('footer_content');
		  $table->string('tab_color')->default("#26a69a");
		  $table->string('main_color')->default("teal");
		  $table->string('color_class')->default("lighten-1");
		  $table->boolean('active')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('synthesiscms_settings');
    }
}
