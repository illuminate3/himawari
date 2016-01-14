<?php
namespace App\Modules\Himawari\Providers;

use Illuminate\Support\ServiceProvider;

use App\Modules\Himawari\Http\Models\Content;

use DB;
use Cache;
use Schema;
use View;

class ViewComposerServiceProvider extends ServiceProvider
{


	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$total_contents = $this->getAllContents();
		View::share('total_contents', $total_contents);

	}


	public function register()
	{
		//
	}


	public function getAllContents()
	{

		if (Schema::hasTable('contents')) {
			$count = count(Content::all());
			if ( $count == null ) {
				$count = 0;
			}
			return $count;
		}

	}


}
