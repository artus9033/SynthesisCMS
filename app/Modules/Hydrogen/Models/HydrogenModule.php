<?php namespace App\Modules\Hydrogen\Models;

use Illuminate\Database\Eloquent\Model;


class HydrogenModule extends Model
{
	protected $fillable = array('id', 'molecule');

	public $timestamps = true;
}
