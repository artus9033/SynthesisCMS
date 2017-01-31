<?php namespace App\Modules\Berylium\Models;

use Illuminate\Database\Eloquent\Model;


class BeryliumModule extends Model
{
	protected $fillable = array('id', 'atom');

	public $timestamps = true;
}
