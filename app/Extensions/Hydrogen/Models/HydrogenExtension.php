<?php namespace App\Extensions\Hydrogen\Models;

use Illuminate\Database\Eloquent\Model;


class HydrogenExtension extends Model
{
	protected $fillable = array('id', 'molecule');

	public $timestamps = true;
}
