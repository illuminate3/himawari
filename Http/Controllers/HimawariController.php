<?php

namespace App\Modules\Himawari\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Theme;


class HimawariController extends Controller
{


	use DispatchesCommands, ValidatesRequests;

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
	}


	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function welcome()
	{
		return Theme::View('himawari::welcome.himawari');
	}


}
