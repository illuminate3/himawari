<?php
namespace App\Modules\Himawari\Providers;

//use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

use App;
use Config;
use Lang;
use Menu;
use View;

class HimawariServiceProvider extends ServiceProvider
{
	/**
	 * Register the Himawari module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\Himawari\Providers\RouteServiceProvider');
		App::register('App\Modules\Himawari\Providers\HimawariMenuProvider');

		$this->mergeConfigFrom(
			__DIR__.'/../Config/himawari.php', 'himawari'
		);

		$this->registerNamespaces();
		$this->registerProviders();

/**
 * Require some HTML macros
 */
//require app_path().'/Modules/Himawari/Lib/helpers.php';
//require app_path().'/Modules/Himawari/Lib/composers.php';
//require app_path().'/Modules/Himawari/Lib/macros.php';


	}

	/**
	 * Register the Himawari module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
//		Lang::addNamespace('himawari', __DIR__.'/../Resources/Lang/');
		View::addNamespace('himawari', __DIR__.'/../Resources/Views/');
	}


	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
			__DIR__.'/../Config/himawari.php' => config_path('himawari.php'),
			__DIR__ . '/../Publish/assets/vendors' => base_path('public/assets/vendors/'),
			__DIR__ . '/../Publish/Plugins' => base_path('app/Plugins/'),
			__DIR__ . '/../Publish/views/plugins/' => base_path('resources/views/plugins/'),
		]);

		$this->publishes([
			__DIR__ . '/../Publish/assets/vendors' => base_path('public/assets/vendors/'),
		], 'js');

		$this->publishes([
			__DIR__ . '/../Publish/Plugins' => base_path('app/Plugins/'),
		], 'plugins');

		$this->publishes([
			__DIR__ . '/../Publish/views/plugins/' => base_path('resources/views/plugins/'),
		], 'views');

/*
		AliasLoader::getInstance()->alias(
			'Menus',
			'TypiCMS\Modules\Menus\Facades\Facade'
		);
*/

	}


	/**
	* add Prvoiders
	*
	* @return void
	*/
	private function registerProviders()
	{
		$app = $this->app;

		$app->register('Cviebrock\EloquentSluggable\SluggableServiceProvider');
		$app->register('Baum\Providers\BaumServiceProvider');
	}


}
