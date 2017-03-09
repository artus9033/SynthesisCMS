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
		$route = str_replace("\\", "/", $route);
		if(!starts_with($route, "/")){
			$ret = true;
			$route = "/" . $route;
		}
		if(!strlen($route) == 1){
			if(ends_with($route, "/")){
				$ret = true;
				$route = substr($route, 0, -1);
			}
		}
		if($ret){
			Toolbox::chkRoute($route);
		}
	}

	static function string_truncate($str, $length){
		return mb_strimwidth($str, 0, $length, "...");
	}

	static function isEven($number){
		if ($number % 2 == 0 ) {
			return true;
		}
		if($number % 2 == 1 ) {
			return false;
		}
	}

	static function getDoubleLocale($locale){
		switch($locale){
			case "pl":
			return "pl_PL";
			break;
			case "en":
			return "en_US";
			break;
			default:
			return "en_US";
			break;
		}
	}

	static function getBrowserLocale()
	{
		// Credit: https://gist.github.com/Xeoncross/dc2ebf017676ae946082
		$websiteLanguages = ['EN', 'PL'];
		// Parse the Accept-Language according to:
		// http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4
		preg_match_all(
			'/([a-z]{1,8})' .       // M1 - First part of language e.g en
			'(-[a-z]{1,8})*\s*' .   // M2 -other parts of language e.g -us
			// Optional quality factor M3 ;q=, M4 - Quality Factor
			'(;\s*q\s*=\s*((1(\.0{0,3}))|(0(\.[0-9]{0,3}))))?/i',
			$_SERVER['HTTP_ACCEPT_LANGUAGE'],
			$langParse);

			$langs = $langParse[1]; // M1 - First part of language
			$quals = $langParse[4]; // M4 - Quality Factor

			$numLanguages = count($langs);
			$langArr = array();

			for ($num = 0; $num < $numLanguages; $num++)
			{
				$newLang = strtoupper($langs[$num]);
				$newQual = isset($quals[$num]) ?
				(empty($quals[$num]) ? 1.0 : floatval($quals[$num])) : 0.0;

				// Choose whether to upgrade or set the quality factor for the
				// primary language.
				$langArr[$newLang] = (isset($langArr[$newLang])) ?
				max($langArr[$newLang], $newQual) : $newQual;
			}

			// sort list based on value
			// langArr will now be an array like: array('EN' => 1, 'ES' => 0.5)
			arsort($langArr, SORT_NUMERIC);

			// The languages the client accepts in order of preference.
			$acceptedLanguages = array_keys($langArr);

			// Set the most preferred language that we have a translation for.
			foreach ($acceptedLanguages as $preferredLanguage)
			{
				if (in_array($preferredLanguage, $websiteLanguages))
				{
					$_SESSION['lang'] = $preferredLanguage;
					return strtolower($preferredLanguage);
				}
			}
		}
	}

	?>
