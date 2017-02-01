<?php namespace App\Extensions\Hydrogen\Models;

use Illuminate\Database\Eloquent\Model;


class HydrogenExtension extends Model
{
	protected $fillable = array('id', 'molecule', 'list_column_count');

	public $timestamps = true;
}
