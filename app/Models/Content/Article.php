<?php

namespace App\Models\Content;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	const cardSizeSmall = "small";
	const cardSizeMedium = "medium";
	const cardSizeLarge = "large";
	const cardSizeNotDefined = "";

	public $timestamps = true;

	protected $table = 'synthesiscms_articles';

	protected $fillable = array('title', 'description', 'articleCategory', 'image', 'hasImage', 'cardSize', 'publishedBy');

	public function getPublisher(){
		$userQuery = User::find(13);
		if($userQuery) {
			$user = $userQuery->first();
		}else{
			$user = User::first();
		}
		return $user->name;
	}

	static function getCardSizeFromNumber($index)
	{
		switch ($index) {
			default:
				//default value
				return Article::cardSizeNotDefined;
			case 0:
				return Article::cardSizeNotDefined;
			case 1:
				return Article::cardSizeSmall;
			case 2:
				return Article::cardSizeMedium;
			case 3:
				return Article::cardSizeLarge;
		}
	}

	static function getCardSizeFromName($name)
	{
		if ($name == Article::cardSizeNotDefined) {
			return 0;
		} else if ($name == Article::cardSizeSmall) {
			return 1;
		} else if ($name == Article::cardSizeMedium) {
			return 2;
		} else if ($name == Article::cardSizeLarge) {
			return 3;
		} else {
			//default value
			return 0;
		}
	}
}
