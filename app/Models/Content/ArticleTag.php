<?php

namespace App\Content;

use Illuminate\Database\Eloquent\Model;

class ArticleTag extends Model
{
	public $timestamps = false;

	protected $table = 'synthesiscms_article_tag';

	protected $fillable = array('article_id', 'tag_id');
}
