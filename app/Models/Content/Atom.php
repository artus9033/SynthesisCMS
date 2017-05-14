<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;

class Atom extends Model
{
	const cardSizeSmall = "small";
	const cardSizeMedium = "medium";
	const cardSizeLarge = "large";
    public $timestamps = true;
	protected $fillable = array('title', 'description', 'molecule', 'image', 'hasImage', 'cardSize');

	static function getCardSizeFromNumber($index)
	{
		switch ($index) {
			default:
				//default value
				return Atom::cardSizeMedium;
			case 0:
				return Atom::cardSizeSmall;
			case 1:
				return Atom::cardSizeMedium;
			case 2:
				return Atom::cardSizeLarge;
		}
	}
}
