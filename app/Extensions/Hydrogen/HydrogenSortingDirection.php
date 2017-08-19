<?php

namespace App\Extensions\Hydrogen;

class HydrogenSortingDirection
{
	const Ascending = 1;
	const Descending = 2;

	static function getConstants()
	{
		$oClass = new \ReflectionClass(__CLASS__);
		return $oClass->getConstants();
	}
}
