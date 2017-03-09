<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	protected $fillable = array('slug', 'extension', 'page_title', 'page_header');

	protected $table = 'synthesiscms_pages';

	public $timestamps = false;
}
