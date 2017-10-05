<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InstallationController extends Controller
{

	public function index(Request $request)
	{
		$reqList = array(
			'4.2' => array(
				'php' => '5.4',
				'mcrypt' => true,
				'pdo' => false,
				'openssl' => false,
				'mbstring' => false,
				'tokenizer' => false,
				'xml' => false,
				'obs' => $laravel42Obs
			),
			'5.0' => array(
				'php' => '5.4',
				'mcrypt' => true,
				'openssl' => true,
				'pdo' => false,
				'mbstring' => true,
				'tokenizer' => true,
				'xml' => false,
				'obs' => $laravel50Obs
			),
			'5.1' => array(
				'php' => '5.5.9',
				'mcrypt' => false,
				'openssl' => true,
				'pdo' => true,
				'mbstring' => true,
				'tokenizer' => true,
				'xml' => false,
				'obs' => ''
			),
			'5.2' => array(
				'php' => '5.5.9',
				'mcrypt' => false,
				'openssl' => true,
				'pdo' => true,
				'mbstring' => true,
				'tokenizer' => true,
				'xml' => false,
				'obs' => ''
			),
			'5.3' => array(
				'php' => '5.6.4',
				'mcrypt' => false,
				'openssl' => true,
				'pdo' => true,
				'mbstring' => true,
				'tokenizer' => true,
				'xml' => true,
				'obs' => ''
			),
			'5.4' => array(
				'php' => '5.6.4',
				'mcrypt' => false,
				'openssl' => true,
				'pdo' => true,
				'mbstring' => true,
				'tokenizer' => true,
				'xml' => true,
				'obs' => ''
			),
		);
		$laravelVersion = '5.4';
		$requirements = array();
		// PHP Version
		$requirements['php_version'] = (version_compare(PHP_VERSION, $reqList[$laravelVersion]['php'], ">=") >= 0);
		// OpenSSL PHP Extension
		$requirements['openssl_enabled'] = extension_loaded("openssl");
		// PDO PHP Extension
		$requirements['pdo_enabled'] = defined('PDO::ATTR_DRIVER_NAME');
		// Mbstring PHP Extension
		$requirements['mbstring_enabled'] = extension_loaded("mbstring");
		// Tokenizer PHP Extension
		$requirements['tokenizer_enabled'] = extension_loaded("tokenizer");
		// XML PHP Extension
		$requirements['xml_enabled'] = extension_loaded("xml");
		// Mcrypt
		$requirements['mcrypt_enabled'] = extension_loaded("mcrypt_encrypt");
		// mod_rewrite
		$requirements['mod_rewrite_enabled'] = null;
		if (function_exists('apache_get_modules')) {
			$requirements['mod_rewrite_enabled'] = in_array('mod_rewrite', apache_get_modules());
		}
		// storage directory permissions
		if(is_writable(storage_path()) && is_readable(storage_path())){
			$requirements['storage_dir_perm_fix_attempted'] = false;
			$requirements['storage_dir_perm'] = true;
		}else{
			$requirements['storage_dir_perm_fix_attempted'] = true;
			$requirements['storage_dir_perm'] = chmod(storage_path(), 0755);
		}
		// public directory permissions
		if(is_writable(public_path()) && is_readable(public_path())){
			$requirements['public_dir_perm_fix_attempted'] = false;
			$requirements['public_dir_perm'] = true;
		}else{
			$requirements['public_dir_perm_fix_attempted'] = true;
			$requirements['public_dir_perm'] = chmod(public_path(), 0755);
		}
		// bootstrap directory permissions
		if(is_writable(base_path('bootstrap')) && is_readable(base_path('bootstrap'))){
			$requirements['bootstrap_dir_perm_fix_attempted'] = false;
			$requirements['bootstrap_dir_perm'] = true;
		}else{
			$requirements['bootstrap_dir_perm_fix_attempted'] = true;
			$requirements['bootstrap_dir_perm'] = chmod(base_path('bootstrap'), 0755);
		}
		return view('installer/pure_html.installation')->with(
			[
				'storage_dir_perm' => $requirements['storage_dir_perm'],
				'storage_dir_perm_fix_attempted' => $requirements['storage_dir_perm_fix_attempted'],
				'public_dir_perm' => $requirements['public_dir_perm'],
				'public_dir_perm_fix_attempted' => $requirements['public_dir_perm_fix_attempted'],
				'bootstrap_dir_perm' => $requirements['bootstrap_dir_perm'],
				'bootstrap_dir_perm_fix_attempted' => $requirements['bootstrap_dir_perm_fix_attempted'],
				'php_version' => $requirements['php_version'],
				'openssl_enabled' => $requirements['openssl_enabled'],
				'pdo_enabled' => $requirements['pdo_enabled'],
				'mbstring_enabled' => $requirements['mbstring_enabled'],
				'tokenizer_enabled' => $requirements['tokenizer_enabled'],
				'xml_enabled' => $requirements['xml_enabled'],
				'mcrypt_enabled' => $requirements['mcrypt_enabled'],
				'mod_rewrite_enabled' => $requirements['mod_rewrite_enabled'],
			]);
	}

}
