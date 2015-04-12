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
	public function asset_status($asset_status_id)
	{
//dd($asset_status_id);
		return $asset_status_id ? trans('kotoba::general.active') : trans('kotoba::general.deactivated');
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



/*

	public function content($id)
	{
		$content = DB::table('catalog')
			->where('id', '=', $id)
			->pluck('name');
//dd($content);
		if ($content == null ) {
			$content = '--- --- --- --- --- ---';
		}
//dd($content);

		return $content;
	}

	public function number($id)
	{
		$number = DB::table('catalog')
			->where('id', '=', $id)
			->pluck('number');
//dd($number);
		if ($number == null ) {
			$number = '--- --- ---';
		}
//dd($number);

		return $number;
	}

	public function location($zone_id, $rack_id)
	{
//dd($zone);
//dd($rack);
		$zone = '';
		$rack = '';
		$location = '';

		if ($zone_id != null ) {
			$zone = DB::table('zones')
				->where('id', '=', $zone_id)
				->pluck('name');
		//dd($zone);

			$location = $zone;
		}
		if ($rack_id != null ) {
			$rack = DB::table('racks')
				->where('id', '=', $rack_id)
				->first();
		//dd($rack);
		//		$racked = $rack->zone . '-' . $rack->aisle . '-' . $rack->level . '-' . $rack->slot;
				$racked = $rack->aisle . '-' . $rack->level . '-' . $rack->slot;

				$location = $zone . '-' . $racked;
		}

		return $location;
	}

}
*/
