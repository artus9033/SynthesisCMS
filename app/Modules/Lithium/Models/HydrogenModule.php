<?php namespace App\Modules\Lithium\Models;

use Illuminate\Database\Eloquent\Model;


class LithiumModule extends Model
{
	protected $fillable = array('id', 'molecule');

	public $timestamps = true;
}
