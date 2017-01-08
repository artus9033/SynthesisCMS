<?php

namespace App;

class Toolbox
{
	static function string_between($string, $start, $end) {
		$string = " ".$string;
		$ini = strpos($string, $start);
		if ($ini == 0) return "";
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}
}

?>
