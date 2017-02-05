<?php namespace App\Extensions\Berylium\Models;

use Illuminate\Database\Eloquent\Model;


class BeryliumExtension extends Model
{
	protected $fillable = array('id', 'enabled');
	//TODO: implement multiple menus that can be added in different page positions
	public $timestamps = true;
}
