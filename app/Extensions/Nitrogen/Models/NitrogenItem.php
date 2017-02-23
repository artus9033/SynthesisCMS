<?php namespace App\Extensions\Nitrogen\Models;

use Illuminate\Database\Eloquent\Model;


class NitrogenItem extends Model
{
	protected $fillable = array('id', 'type', 'category', 'title', 'data', 'parentOf', 'before', 'slider');

	public $timestamps = false;
}
