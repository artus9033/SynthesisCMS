<?php namespace App\Extensions\Berylium\Models;

use Illuminate\Database\Eloquent\Model;

class BeryliumItem extends Model
{
	public $timestamps = false;
	protected $fillable = array('id', 'type', 'category', 'title', 'data', 'parentOf', 'before', 'menu');
}
