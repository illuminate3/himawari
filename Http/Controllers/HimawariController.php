<?php

namespace App\Modules\Himawari\Http\Controllers;

use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Bus\DispatchesCommands;
// use Illuminate\Routing\Controller as BaseController;
// use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Modules\Core\Http\Traits\SeoTrait;

use Cache;
//use Session;
use Theme;


class HimawariController extends Controller
{

	use SeoTrait;

// 	use DispatchesCommands, ValidatesRequests;

	/**
	 * Initializer.
	 *
	 * @return \HimawariController
	 */
	public function __construct()
	{
// middleware
		$this->middleware('auth');
		$this->middleware('admin');
		$this->middleware('himawari');
	}


	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function welcome()
	{
		return Theme::View('modules.himawari.welcome.himawari');
	}


	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function changeSite($site_id)
	{
//dd($site_id);
//		Session::put('siteId', $site_id);
		Cache::forget('siteId');
		Cache::forever('siteId', $site_id);

//		return Redirect::back();
		return redirect('/admin/contents');
	}


}
