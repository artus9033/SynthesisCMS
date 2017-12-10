<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
	public $timestamps = false;
	protected $table = 'synthesiscms_settings';
	protected $fillable = array('home_page', 'header_title', 'tab_title',
		'show_login_register_buttons', 'footer_copyright', 'footer_more_links_bottom_text',
		'footer_more_links_bottom_href', 'footer_links_text', 'footer_links_content',
		'footer_header', 'footer_content', 'tab_color', 'main_color', 'color_class',
		'synthesiscms_installed_extensions', 'devModeEnabled', 'logo_background_color',
		'show_image_big_banner', 'site_enabled');

	public static function getTableName()
	{
		return with(new static)->getTable();
	}

	public function getInstalledExtensions()
	{
		return array_filter(explode(';', $this->synthesiscms_installed_extensions));
	}

	public static function getActiveInstance()
	{
		if(\App::make('synthesiscmsSettingsTableError')) {
			/**
			 * this constant is true when the app fails to access
			 * the settings table during bootstrap procedure,
			 * therefore it cannot initialize the
			 * synthesiscmsActiveSettingsInstance singleton.
			 * Return null to avoid a crash here.
			 */
			return null;
		}else{
			return \App::make('synthesiscmsActiveSettingsInstance');
		}
	}

	public function installExtension($extensionName)
	{
		//TODO: implement this method
	}

	public function uninstallExtension($extensionName)
	{
		//TODO: implement this method
	}

	public function isDevModeEnabled()
	{
		return $this->getField('devModeEnabled');
	}

	public static function getFromActive($field)
	{
		return self::getActiveInstance()->getField($field);
	}

	public function getField($field){
		return $this->$field;
	}
}
