<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\BackendRequest;
use App\Models\Settings\Settings;
use App\Toolbox;
use Illuminate\Support\Facades\Auth;

class BackendController extends Controller
{
	public function index()
	{
		if(Auth::check() && Auth::user()->is_admin){
			return view('admin.admin');
		}else{
			return view('auth.error');
		}
	}

	public function settingsGet(){
		return view('admin.settings');
	}

	public function settingsPost(BackendRequest $request){
		$settings = Settings::getActiveInstance();
		$settings->home_page = $request->get('home_page');
		$settings->header_title = $request->get('header_title');
		$settings->tab_title = $request->get('tab_title');
		$settings->footer_copyright = $request->get('footer_copyright');
		$settings->footer_more_links_bottom_text = $request->get('footer_more_links_bottom_text');
		$settings->footer_more_links_bottom_href = $request->get('footer_more_links_bottom_href');
		$settings->footer_links_text = $request->get('footer_links_text');
		$settings->footer_links_content = $request->get('footer_links_content');
		$settings->footer_header = $request->get('footer_header');
		$settings->footer_content = $request->get('footer_content');
		$settings->tab_color = $request->get('tab_color');
		$settings->main_color = $request->get('main_color');
		$settings->color_class = $request->get('main_color_class');
		$settings->save();
		return \Redirect::route('settings')->with('messages', array(trans('synthesiscms/settings.msg_saved')));
	}

	public function manageAppletsGet(){
		return view('admin.manage_applets');
	}

	public function appletSettingsGet($extension){
		return view('admin.applet_settings')->with(['extension' => $extension]);
	}

	public function appletSettingsPost($extension, BackendRequest $request){
		$errors = array();
		$err = false;

		if(!$err){
			Toolbox::chkRoute($slug);
		}

		if($err){
			return \Redirect::to(\Request::path())->with('errors', $extension);
		}else{
			$kpath = 'App\\Extensions\\'.$extension.'\\ExtensionKernel';
			$kernel = new $kpath;
			$errors = Array();
			$messages = Array();
			array_push($messages, trans('synthesiscms/admin.msg_applet_settings_saved', ['applet' => $kernel->getExtensionName()]));
			$kernel->settingsPost($request, $errors, $messages);
			return \Redirect::route("applet_settings", $extension)->with(['messages' => $messages, 'errors' => $errors]);
		}
	}
}
