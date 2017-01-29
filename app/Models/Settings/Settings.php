<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
	protected $fillable = array('header_title', 'tab_title', 'footer_copyright', 'footer_more_links_bottom_text', 'footer_more_links_bottom_href', 'footer_links_text', 'footer_links_content', 'footer_header', 'footer_content', 'tab_color', 'main_color');
	//TODO: add settings_edit view
	//TODO: implement saving settings as different settings profiles
     public $timestamps = false;

	public static function getFromActive($field){
		$settings_instance = Settings::where('active', true)->first();
		return $settings_instance->$field;
	}
}
