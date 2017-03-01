<?php namespace App\Extensions\Nitrogen\Models;

use Illuminate\Database\Eloquent\Model;


class NitrogenItem extends Model
{
	protected $fillable = array('id', 'type', 'title', 'content', 'before', 'slider', 'titleTextColor', 'contentTextColor');

	public $timestamps = false;
}
