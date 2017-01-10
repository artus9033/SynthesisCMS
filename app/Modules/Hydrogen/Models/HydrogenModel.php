<?php namespace App\Modules\Hydrogen\Models;

use Illuminate\Database\Eloquent\Model;


class HydrogenModel extends Model
{
	protected $fillable = array('title', 'content', 'image');

	public $timestamps = true;
}
