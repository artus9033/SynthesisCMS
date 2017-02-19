<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MobileDetectionProvider extends ServiceProvider
{
	/**
	* Bootstrap the application services.
	*
	* @return void
	*/
	public function boot()
	{
		if(!\App::runningInConsole()){
			$tablet_browser = 0;
			$mobile_browser = 0;

			if(preg_match("/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i", strtolower($_SERVER["HTTP_USER_AGENT"]))) {
				$mobile_browser++;
			}

			if((strpos(strtolower($_SERVER["HTTP_ACCEPT"]),"application/vnd.wap.xhtml+xml") > 0) or ((isset($_SERVER["HTTP_X_WAP_PROFILE"]) or isset($_SERVER["HTTP_PROFILE"])))) {
				$mobile_browser++;
			}

			$mobile_ua = strtolower(substr($_SERVER["HTTP_USER_AGENT"], 0, 4));

			$mobile_agents = array(

				"w3c ","acs-","alav","alca","amoi","audi","avan","benq","bird","blac",

				"blaz","brew","cell","cldc","cmd-","dang","doco","eric","hipt","inno",

				"ipaq","java","jigs","kddi","keji","leno","lg-c","lg-d","lg-g","lge-",

				"maui","maxo","midp","mits","mmef","mobi","mot-","moto","mwbp","nec-",

				"newt","noki","palm","pana","pant","phil","play","port","prox",

				"qwap","sage","sams","sany","sch-","sec-","send","seri","sgh-","shar",

				"sie-","siem","smal","smar","sony","sph-","symb","t-mo","teli","tim-",

				"tosh","tsm-","upg1","upsi","vk-v","voda","wap-","wapa","wapi","wapp",

				"wapr","webc","winw","winw","xda ","xda-");

				if(in_array($mobile_ua,$mobile_agents)) {
					$mobile_browser++;
				}

				if(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]),"opera mini") > 0) {
					$mobile_browser++;
					$stock_ua = strtolower(isset($_SERVER["HTTP_X_OPERAMINI_PHONE_UA"])?$_SERVER["HTTP_X_OPERAMINI_PHONE_UA"]:(isset($_SERVER["HTTP_DEVICE_STOCK_UA"])?$_SERVER["HTTP_DEVICE_STOCK_UA"]:""));
					if(preg_match("/(tablet|ipad|playbook)|(android(?!.*mobile))/i", $stock_ua)) {
						$tablet_browser++;
					}
				}

				$bIsTablet = false;
				$bIsPhone = false;
				$bIsPc = false;

				if($tablet_browser > 0) {
					$bIsTablet = true;
				}

				else if($mobile_browser > 0) {
					$bIsPhone = true;
				}

				else{
					$bIsPc = true;
				}

				view()->share("synthesiscmsClientIsPhone", $bIsPhone ? 1 : 0);

				view()->share("synthesiscmsClientIsTablet", $bIsTablet ? 1 : 0);

				view()->share("synthesiscmsClientIsDesktop", $bIsPc ? 1 : 0);

				view()->share("synthesiscmsClientIsAnyMobile", ($bIsPhone || $bIsTablet) ? 1 : 0);
			}
		}

		/**
		* Register the application services.
		*
		* @return void
		*/
		public function register()
		{
			//
		}
	}
