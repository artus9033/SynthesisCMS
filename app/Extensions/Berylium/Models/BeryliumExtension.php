<?php namespace App\Extensions\Berylium\Models;

use Illuminate\Database\Eloquent\Model;

class BeryliumExtension extends Model
{
	public $timestamps = true;
	protected $fillable = array('id', 'enabled');
}
