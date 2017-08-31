<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
	public $timestamps = false;
	protected $fillable = array('home_page', 'header_title', 'tab_title', 'footer_copyright', 'footer_more_links_bottom_text', 'footer_more_links_bottom_href', 'footer_links_text', 'footer_links_content', 'footer_header', 'footer_content', 'tab_color', 'main_color', 'color_class', 'synthesiscms_installed_extensions', 'devModeEnabled', 'logo_background_color');
	protected $table = 'synthesiscms_settings';

	public static function getInstalledExtensions()
	{
		return array_filter(explode(';', self::getActiveInstance()->synthesiscms_installed_extensions));
	}

	public static function getActiveInstance()
	{
		return self::where('active', true)->first();
	}

	public static function installExtension($extensionName)
	{
		//TODO: implement this method
	}

	public static function unistallExtension($extensionName)
	{
		//TODO: implement this method
	}

	public static function isDevModeEnabled()
	{
		return self::getFromActive('devModeEnabled');
	}

	public static function getFromActive($field)
	{
		return self::getActiveInstance()->$field;
	}
}
