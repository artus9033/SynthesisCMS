<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	protected $fillable = array('slug', 'module', 'page_title', 'page_header');

	public $timestamps = false;
}
