<?php
namespace App\Modules\Himawari\Providers;

use App\Providers\MenuServiceProvider;

use Auth;
use Menu;

class HimawariMenuProvider extends MenuServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{

// navbar menu
//		if ( (Auth::user()->can('manage_admin')) || (Auth::user()->can('manage_himawari')) ) {
		$menu = Menu::get('navbar');
		$menu->add('Scans', 'scans')->data('order', 4);
		$menu->add('Assets', 'assets')->data('order', 3);

// 		$menu->add('Pages',
// 			array(
// 				'class' => '',
// 				'id' => 'showLeft'
// 			))
// 			->link->href('#');

		$menu->assets->add('Assets', 'admin/asset');
		$menu->assets->add('Contents', 'admin/contents');
		$menu->assets->add('Pages', 'pages');
		$menu->assets->add('Asset Statuses', 'admin/asset_statuses');
		$menu->assets->add('Tech Statuses', 'admin/tech_statuses');
		$menu->sortBy('order');
//		}

// right side drop down
//		$menu = Menu::get('admin');

	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
//
	}



}
