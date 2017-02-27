<?php namespace App\Extensions\Nitrogen\Models;

use Illuminate\Database\Eloquent\Model;


class NitrogenItem extends Model
{
	protected $fillable = array('id', 'type', 'buttonLink', 'buttonText', 'buttonWavesColor', 'buttonColor', 'buttonClass', 'hasButton', 'title', 'content', 'before', 'slider');

	public $timestamps = false;
}
