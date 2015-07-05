<?php
namespace App\Modules\Himawari\Http\Presenters;

use Laracasts\Presenter\Presenter;

use DB;


class Himawari extends Presenter {


	/**
	 * Present name
	 *
	 * @return string
	 */
	public function name()
	{
		return ucwords($this->entity->name);
	}

	public function pageName($id)
	{
		$title = DB::table('pages')
			->where('id', '=', $id)
			->pluck('title');
//dd($customer);

		return $title;
	}



	/**
	 * Present asset_status
	 *
	 * @return string
	 */
	public function print_status($print_status_id)
	{
//dd($print_status_id);
//		return $print_status_id ? trans('kotoba::general.active') : trans('kotoba::general.deactivated');
		$print_status = DB::table('print_statuses')
			->where('id', '=', $print_status_id)
			->pluck('name');

		return $print_status;

	}


	/**
	 * Present the profiles
	 *
	 * @return string
	 */
	public function site($site_id)
	{
		$return   = '';
//dd($sites);

		if ( $site_id == null ) {
			$return = trans('kotoba::general.empty');
		} else {
			$site = DB::table('sites')
				->where('id', '=', $site_id)
				->pluck('name');
		}

		return $site;
	}



}
