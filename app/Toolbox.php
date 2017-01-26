<?php

namespace App;

class Toolbox
{
	static function getBeforeContents($str, $startDelimiter, $endDelimiter) {
	  $contents = array();
	  $startDelimiterLength = strlen($startDelimiter);
	  $endDelimiterLength = strlen($endDelimiter);
	  $startFrom = $contentStart = $contentEnd = 0;
	  while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
	    $contentStart += $startDelimiterLength;
	    $contentEnd = strpos($str, $endDelimiter, $contentStart);
	    if (false === $contentEnd) {
	      break;
	    }
	    $contents[] = substr($str, 0, $contentEnd + 1);
	    $startFrom = $contentEnd + $endDelimiterLength;
	  }

	  return $contents;
	}

	static function str_replace_first($from, $to, $subject)
	{
	    $from = '/'.preg_quote($from, '/').'/';

	    return preg_replace($from, $to, $subject, 1);
	}

	static function isEmptyString($string){
		return strlen(trim($string)) == 0;
	}

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
