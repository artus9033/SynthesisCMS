<?php namespace App\Extensions\Berylium\Models;

use Illuminate\Database\Eloquent\Model;


class BeryliumExtension extends Model
{
	protected $fillable = array('id', 'atom');

	public $timestamps = true;
}
