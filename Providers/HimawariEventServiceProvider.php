<?php

namespace App\Modules\Himawari\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Providers\EventServiceProvider;

use App\Modules\Jinji\Events\EmployeeWasCreated;
use App\Modules\Jinji\Handlers\Events\CreateEmployee;
use App\Modules\Jinji\Events\EmployeeWasDeleted;
use App\Modules\Jinji\Handlers\Events\DeleteEmployee;

use App\Modules\Kagi\Http\Models\User;

use App;
use Event;


class JinjiEventServiceProvider extends EventServiceProvider {


	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [

		EmployeeWasCreated::class => [
			CreateEmployee::class,
		],

		EmployeeWasDeleted::class => [
			DeleteEmployee::class,
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

		User::created(function ($user) {
//dd($user);
			\Event::fire(new EmployeeWasCreated($user));
		});

		User::deleted(function ($user) {
//dd($user);
			\Event::fire(new EmployeeWasDeleted($user));
		});

	}


	public function register()
	{

		$loader = \Illuminate\Foundation\AliasLoader::getInstance();
		$loader->alias('EmployeeWasCreated', 'App\Modules\Jinji\Events\EmployeeWasCreated');

		$loader = \Illuminate\Foundation\AliasLoader::getInstance();
		$loader->alias('EmployeeWasDeleted', 'App\Modules\Jinji\Events\EmployeeWasDeleted');

	}


}
