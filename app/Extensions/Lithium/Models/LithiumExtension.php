<?php namespace App\Extensions\Lithium\Models;

use Illuminate\Database\Eloquent\Model;


class LithiumExtension extends Model
{
	public $timestamps = true;
	protected $fillable = array('id', 'article', 'showHeader');
}
