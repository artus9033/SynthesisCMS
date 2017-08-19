<?php

namespace App\Extensions\Hydrogen;

class HydrogenSortingType
{
	const Alphabetical = 1;
	const CreationDate = 2;
	const ModificationDate = 3;

	static function getConstants()
	{
		$oClass = new \ReflectionClass(__CLASS__);
		return $oClass->getConstants();
	}
}
