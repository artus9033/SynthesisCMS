<?php namespace App\Extensions\Boron\Models;

use Illuminate\Database\Eloquent\Model;

class BoronExtension extends Model
{
	public $timestamps = false;
	protected $fillable = array('id', 'enabled', 'url', 'facebookAppId');
}
