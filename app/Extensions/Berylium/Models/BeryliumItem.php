<?php namespace App\Extensions\Berylium\Models;

use Illuminate\Database\Eloquent\Model;


class BeryliumItem extends Model
{
	protected $fillable = array('id', 'type', 'category', 'title', 'href', 'parentOf', 'before', 'menu');

	public $timestamps = false;
}
