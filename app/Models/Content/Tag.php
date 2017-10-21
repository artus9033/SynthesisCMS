<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	public $timestamps = false;

	protected $table = 'synthesiscms_tags';

	protected $fillable = array('name');



}
