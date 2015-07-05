<?php
namespace App\Modules\Himawari\Providers;

use Illuminate\Support\ServiceProvider;

use App\Modules\Himawari\Http\Domain\Models\Content as Content;

// use Auth;
// use Cache;
use Config;
// use DB;
//use Menu;
use Plugin;
// use Session;
// use View;

class HimawariMenuProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{

Plugin::register('MenuNavigation', 'App\Plugins\MenuNavigation');
/*
		Menu::handler('top')->hydrate(function()
			{
//			$pages = Content::get();
			$pages = Content::orderBy('order')->get();
//dd($pages);
			return $pages;
			},
			function($children, $item)
			{
				if($item->depth < 1) {
					$children->add($item->translate(Config::get('app.locale'))->slug, $item->translate(Config::get('app.locale'))->title, Menu::items($item->as));
				}
			});



		Menu::handler('right')->hydrate(function()
			{
			$pages = Content::get();
//dd($pages);
			return $pages;
			},
			function($children, $item)
			{
				$children->add($item->translate(Config::get('app.locale'))->slug, $item->translate(Config::get('app.locale'))->title, Menu::items($item->as));
			});
*/

/*
// navbar menu
//		if ( (Auth::user()->can('manage_admin')) || (Auth::user()->can('manage_himawari')) ) {
		$menu = Menu::get('navbar');
		$menu->add('Pages', 'pages')->data('order', 5);
		$menu->pages->add('Pages', 'pages');
		$menu->pages->add('Print Statuses', 'admin/print_statuses');
		$menu->sortBy('order');
//		}
// right side drop down
//		$menu = Menu::get('admin');
*/
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
