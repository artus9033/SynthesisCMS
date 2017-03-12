<?php namespace App\Extensions\Boron\Models;

use Illuminate\Database\Eloquent\Model;


class BoronExtension extends Model
{
	protected $fillable = array('id', 'enabled', 'url', 'facebookAppId');

	public $timestamps = false;
}
