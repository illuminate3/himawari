<?php

namespace App\Modules\Himawari\Providers;

use Illuminate\Support\ServiceProvider;

use App\Modules\Himawari\Http\Models\Content;

use DB;
use Cache;
use Config;
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

//		$total_contents = $this->getAllContents();
		$content_drafts = $this->getContentDrafts();


//		View::share('total_contents', $total_contents);
		View::share('content_drafts', $content_drafts);

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


	public function getContentDrafts()
	{

		if (Schema::hasTable('contents')) {
			$drafts = DB::table('contents')
				->where('print_status_id', '=', Config::get('himawari.default_publish_status'))
				->get();
			$count = count($drafts);
			if ( $count == null ) {
				$count = 0;
			}
			return $count;
		}

	}


}
