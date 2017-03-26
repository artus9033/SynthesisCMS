<?php namespace App\Extensions\Lithium\Models;

use Illuminate\Database\Eloquent\Model;


class LithiumExtension extends Model
{
	protected $fillable = array('id', 'atom', 'showHeader');

	public $timestamps = true;
}
