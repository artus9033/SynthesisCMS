<?php namespace App\Extensions\Nitrogen\Models;

use Illuminate\Database\Eloquent\Model;


class NitrogenItem extends Model
{
	public $timestamps = false;
	protected $fillable = array('id', 'image', 'color', 'title', 'content', 'before', 'slider', 'titleTextColor', 'contentTextColor', 'parentInstance');
}
