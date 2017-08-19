<?php namespace App\Extensions\Nitrogen\Models;

use Illuminate\Database\Eloquent\Model;


class NitrogenExtension extends Model
{
	public $timestamps = true;
	protected $fillable = array('id', 'title', 'enabled', 'buttonLink', 'buttonText', 'buttonTextColor', 'buttonWavesColor', 'buttonColor', 'buttonClass', 'hasButton', 'assignedPages', 'autoplay', 'buttons', 'interval', 'assignedToAllPages');
}
