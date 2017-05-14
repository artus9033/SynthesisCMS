<?php namespace App\Extensions\Hydrogen\Models;

use Illuminate\Database\Eloquent\Model;


class HydrogenExtension extends Model
{
	public $timestamps = true;
	protected $fillable = array('id', 'molecule', 'list_column_count', 'default_sorting_type', 'default_sorting_direction', 'atoms_on_single_page', 'showHeader');
}
