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

	static function chkRoute(&$route){
		$ret = false;
		if(!starts_with($route, "/")){
			$ret = true;
			$route = "/" . $route;
		}
		if(ends_with($route, "/")){
			$ret = true;
			$route = substr($route, 0, -1);
		}
		if($ret){
			Toolbox::chkRoute($route);
		}
	}

	static function string_truncate($str, $length){
		$retstr = substr($str, 0 , $length);
		if(strlen($str) > $length){
			$retstr .= "...";
		}
		return $retstr;
	}

	static function isEven($number){
		if ($number % 2 == 0 ) {
			return true;
		}
		if($number % 2 == 1 ) {
			return false;
		}
	}
}

?>
