<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
	protected $fillable = array('header_title', 'tab_title', 'footer_copyright', 'footer_more_links_bottom_text', 'footer_more_links_bottom_href', 'footer_links_text', 'footer_links_content', 'footer_header', 'footer_content', 'tab_color', 'main_color', 'color_class');

	protected $table = 'synthesiscms_settings';

     public $timestamps = false;

	public static function getActiveInstance(){
		return Settings::where('active', true)->first();
	}

	public static function getFromActive($field){
		$settings_instance = self::getActiveInstance();
		return $settings_instance->$field;
	}
}
