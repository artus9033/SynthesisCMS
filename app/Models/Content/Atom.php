<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;

class Atom extends Model
{
	const cardSizeSmall = "small";
	const cardSizeMedium = "medium";
	const cardSizeLarge = "large";
	const cardSizeNotDefined = "";

    public $timestamps = true;

	protected $fillable = array('title', 'description', 'molecule', 'image', 'hasImage', 'cardSize');

	static function getCardSizeFromNumber($index)
	{
		switch ($index) {
			default:
				//default value
				return Atom::cardSizeNotDefined;
			case 0:
				return Atom::cardSizeNotDefined;
			case 1:
				return Atom::cardSizeSmall;
			case 2:
				return Atom::cardSizeMedium;
			case 3:
				return Atom::cardSizeLarge;
		}
	}

	static function getCardSizeFromName($name)
	{
		if ($name == Atom::cardSizeNotDefined) {
			return 0;
		} else if ($name == Atom::cardSizeSmall) {
			return 1;
		} else if ($name == Atom::cardSizeMedium) {
			return 2;
		} else if ($name == Atom::cardSizeLarge) {
			return 3;
		} else {
			//default value
			return 0;
		}
	}
}
