<?php namespace App\Extensions\Nitrogen\Models;

use Illuminate\Database\Eloquent\Model;


class NitrogenExtension extends Model
{
	protected $fillable = array('id', 'enabled', 'buttonLink', 'buttonText', 'buttonTextColor', 'buttonWavesColor', 'buttonColor', 'buttonClass', 'hasButton', 'assignedPages', 'autoplay', 'buttons', 'interval');

	public $timestamps = true;
}
