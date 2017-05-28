<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
	public $timestamps = true;
	protected $fillable = array('title', 'description');

	public function getAmount()
	{
		return Article::where('articleCategory', $this->id)->count();
	}
}
