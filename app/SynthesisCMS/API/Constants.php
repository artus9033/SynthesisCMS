<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 22.08.2017
 * Time: 22:27
 */

namespace App\SynthesisCMS\API;

abstract class Constants
{
	const tagName = 'SYNTHESISCMS_DYNAMIC_URL_';
	const synthesiscmsUrlMiddlewareHandlerStartTag = "{%" . Constants::tagName . "START%}";
	const synthesiscmsUrlMiddlewareHandlerEndTag = "{%" . Constants::tagName . "END%}";
}