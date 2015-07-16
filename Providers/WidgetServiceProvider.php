<?php

namespace App\Modules\Himawari\Providers;

use Illuminate\Support\ServiceProvider;

use Caffeinated\Modules\Facades\Module;
use Widget;


class WidgetServiceProvider extends ServiceProvider {


	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
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

// 		Plugin::register('Featured', 'App\Plugins\Featured');
// 		Plugin::register('Timed', 'App\Plugins\Timed');


// Individually
// 		Widget::register('MenuAdmin', 'App\Widgets\MenuAdmin');
// 		Widget::register('MenuFooter', 'App\Widgets\MenuFooter');
//
// 		if ( Module::exists('himawari') ) {
// 			Widget::register('MenuNavigation', 'App\Widgets\MenuNavigation');
// 		}

	}


}
