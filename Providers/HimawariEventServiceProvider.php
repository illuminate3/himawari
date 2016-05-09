<?php

namespace App\Modules\Himawari\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Providers\EventServiceProvider;

use App\Modules\Himawari\Events\ContentWasCreated;
use App\Modules\Himawari\Handlers\Events\CreateContent;
use App\Modules\Himawari\Events\ContentWasUpdated;
use App\Modules\Himawari\Handlers\Events\UpdateContent;

use App\Modules\Himawari\Http\Models\Content;

use App;
use Event;


class HimawariEventServiceProvider extends EventServiceProvider {


	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [

		ContentWasCreated::class => [
			CreateContent::class,
		],

		ContentWasUpdated::class => [
			UpdateContent::class,
		],

	];


	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events)
	{
		parent::boot($events);

// 		Content::created(function ($content) {
// 			\Event::fire(new ContentWasCreated($content));
// 		});
//
// 		Content::saved(function ($content) {
// 			\Event::fire(new ContentWasUpdated($content));
// 		});

	}


	public function register()
	{

		$loader = \Illuminate\Foundation\AliasLoader::getInstance();
		$loader->alias('ContentWasCreated', 'App\Modules\Himawari\Events\ContentWasCreated');

		$loader = \Illuminate\Foundation\AliasLoader::getInstance();
		$loader->alias('ContentWasUpdated', 'App\Modules\Himawari\Events\ContentWasUpdated');

	}


}
