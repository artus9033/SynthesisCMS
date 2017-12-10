<?php

namespace App\SynthesisCMS\API\Auth;

class UserPrivilegesManager
{
	//TODO: implement privilege management adding `$user->condition || [...]`

	static function isAuthenticated()
	{
		return \Auth::check();
	}

	static function isGuest(){
		return \Auth::guest();
	}

	static function isContentEditor()
	{
		return (self::isAuthenticated() ? self::__isContentEditor() : false);
	}

	static function isContentManager()
	{
		return (self::isAuthenticated() ? self::__isContentManager() : false);
	}

	static function isSiteManager()
	{
		return (self::isAuthenticated() ? self::__isSiteManager() : false);
	}

	static function isSiteAdministrator()
	{
		return (self::isAuthenticated() ? self::__isSiteAdministrator() : false);
	}

	private static function __isContentEditor()
	{
		return (self::__isContentManager() || self::__isSiteManager() || self::__isSiteAdministrator());
	}

	private static function __isContentManager()
	{
		return (self::__isSiteManager() || self::__isSiteAdministrator());
	}

	private static function __isSiteManager()
	{
		return (self::__isSiteAdministrator());
	}

	private static function __isSiteAdministrator()
	{
		return (\Auth::user()->is_admin);
	}
}

?>
