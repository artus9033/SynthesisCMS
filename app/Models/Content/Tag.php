<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	public $timestamps = false;

	protected $table = 'synthesiscms_tags';

	protected $fillable = array('name');

	public function posts() {
		return $this->belongsToMany(Article::class, 'synthesiscms_article_tag', 'article_id', 'tag_id');
	}

}
