<?php

namespace App\Modules\Himawari\Http\Controllers;

use App\Http\Controllers\Controller;

use Cache;
use Theme;


class HimawariController extends Controller
{

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


}
