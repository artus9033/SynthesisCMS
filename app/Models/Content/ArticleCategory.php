<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
	public $timestamps = true;

	protected $fillable = array('title', 'description');

	protected $table = 'synthesiscms_article_categories';

	public function getAmount()
	{
		return Article::where('articleCategory', $this->id)->count();
	}
}
