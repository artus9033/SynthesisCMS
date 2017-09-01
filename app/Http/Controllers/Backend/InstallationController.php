<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InstallationController extends Controller
{

	public function index(Request $request)
	{
		return view('admin.admin_dashboard');
	}
	
}
