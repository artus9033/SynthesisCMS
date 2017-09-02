<?php

namespace App;

use App\SynthesisCMS\API\Constants;
use DirectoryIterator;

class Toolbox
{
	static function addMessageToBag($message)
	{
		$array = (count(\Session::get('messages')) ? \Session::get('messages') : Array());
		array_push($array, $message);
		\Session::put('messages', $array);
	}

	static function addMessagesToBag($messages)
	{
		$array = (count(\Session::get('messages')) ? \Session::get('messages') : Array());
		foreach ($messages as $message) {
			array_push($array, $message);
		}
		\Session::put('messages', $array);
	}

	static function hasMessageInBag($search)
	{
		$found = false;
		$array = (count(\Session::get('messages')) ? \Session::get('messages') : Array());
		foreach ($array as $item) {
			if ($item === $search) {
				$found = true;
			}
		}
		return $found;
	}

	static function addToastToBag($toast)
	{
		$array = (count(\Session::get('toasts')) ? \Session::get('toasts') : Array());
		array_push($array, $toast);
		\Session::put('toasts', $array);
	}

	static function addToastsToBag($toasts)
	{
		$array = (count(\Session::get('toasts')) ? \Session::get('toasts') : Array());
		foreach ($toasts as $toast) {
			array_push($array, $toast);
		}
		\Session::put('toasts', $array);
	}

	static function hasToastInBag($search)
	{
		$found = false;
		$array = (count(\Session::get('toasts')) ? \Session::get('toasts') : Array());
		foreach ($array as $item) {
			if ($item === $search) {
				$found = true;
			}
		}
		return $found;
	}

	static function addWarningToBag($warning)
	{
		$array = (count(\Session::get('warnings')) ? \Session::get('warnings') : Array());
		array_push($array, $warning);
		\Session::put('warnings', $array);
	}

	static function addWarningsToBag($warnings)
	{
		$array = (count(\Session::get('warnings')) ? \Session::get('warnings') : Array());
		foreach ($warnings as $warning) {
			array_push($array, $warning);
		}
		\Session::put('warnings', $array);
	}

	static function hasWarningInBag($search)
	{
		$found = false;
		$array = (count(\Session::get('warnings')) ? \Session::get('warnings') : Array());
		foreach ($array as $item) {
			if ($item === $search) {
				$found = true;
			}
		}
		return $found;
	}

	static function isDirectoryEmpty($dir)
	{
		foreach (new DirectoryIterator($dir) as $fileInfo) {
			if ($fileInfo->isDot()) continue;
			return false;
		}
		return true;
	}

	static function hex2rgba($color, $opacity = 1)
	{
		$default = 'rgb(0,0,0)';
		if (empty($color))
			return $default;
		if ($color[0] == '#') {
			$color = substr($color, 1);
		}
		if (strlen($color) == 6) {
			$hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
		} elseif (strlen($color) == 3) {
			$hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
		} else {
			return $default;
		}
		$rgb = array_map('hexdec', $hex);
		if ($opacity) {
			if (abs($opacity) > 1)
				$opacity = 1.0;
			$output = 'rgba(' . implode(",", $rgb) . ',' . str_replace(',', '.', $opacity) . ')';
		} else {
			$output = 'rgb(' . implode(",", $rgb) . ')';
		}
		return $output;
	}

	static function human_filesize($bytes, $decimals = 2)
	{
		$size = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
	}

	static function getBeforeContents($str, $startDelimiter, $endDelimiter)
	{
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
		$from = '/' . preg_quote($from, '/') . '/';

		return preg_replace($from, $to, $subject, 1);
	}

	static function isEmptyString($string)
	{
		return strlen(trim($string)) == 0;
	}

	static function string_between($string, $start, $end)
	{
		$string = " " . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return "";
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}

	static function chkRoute(&$route)
	{
		$ret = false;
		$route = str_replace("\\", "/", $route);
		if (!starts_with($route, "/")) {
			$ret = true;
			$route = "/" . $route;
		}
		if (!strlen($route) == 1) {
			if (ends_with($route, "/")) {
				$ret = true;
				$route = substr($route, 0, -1);
			}
		}
		if ($ret) {
			Toolbox::chkRoute($route);
		}
	}

	static function string_truncate($str, $length)
	{
		return mb_strimwidth($str, 0, $length, "...");
	}

	static function string_truncate_no_dots($str, $length)
	{
		return mb_strimwidth($str, 0, $length, "");
	}

	static function isEven($number)
	{
		if ($number % 2 == 0) {
			return true;
		}
		if ($number % 2 == 1) {
			return false;
		}
	}

	static function getFullNameLocale($locale)
	{
		switch ($locale) {
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

		for ($num = 0; $num < $numLanguages; $num++) {
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
		foreach ($acceptedLanguages as $preferredLanguage) {
			if (in_array($preferredLanguage, $websiteLanguages)) {
				$_SESSION['lang'] = $preferredLanguage;
				return strtolower($preferredLanguage);
			}
		}
	}

	static function addServerSideSynthesisDynamicUrlHandlerTags($relativeUrl)
	{
		return (Constants::synthesiscmsUrlMiddlewareHandlerStartTag . $relativeUrl . Constants::synthesiscmsUrlMiddlewareHandlerEndTag);
	}
}

?>
