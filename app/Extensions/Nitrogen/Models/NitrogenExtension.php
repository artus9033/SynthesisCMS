<?php namespace App\Extensions\Nitrogen\Models;

use Illuminate\Database\Eloquent\Model;


class NitrogenExtension extends Model
{
	protected $fillable = array('id', 'enabled');
	//TODO: implement multiple sliders that can be added in different page positions
	public $timestamps = true;
}
