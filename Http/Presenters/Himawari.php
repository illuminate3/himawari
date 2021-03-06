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
	 * Present print_status
	 *
	 * @return string
	 */
	public function print_status($print_status_id)
	{
//dd($print_status_id);
//		return $print_status_id ? trans('kotoba::general.active') : trans('kotoba::general.deactivated');
		$print_status = DB::table('print_status_translations')
			->where('id', '=', $print_status_id)
			->pluck('name');

		return $print_status;

	}


	/**
	 * featured checkbox
	 *
	 * @return string
	 */
	public function checkNavigation()
	{
//dd('loaded');
		$return = '';

		$navigation = $this->entity->is_navigation;
//dd($navigation);
		if ( $navigation == 1 ) {
			$return = "checked";
		}

		return $return;
	}


	/**
	 * timed checkbox
	 *
	 * @return string
	 */
	public function checkTimed()
	{
//dd('loaded');
		$return = '';

		$timed = $this->entity->is_timed;
//dd($timed);
		if ( $timed == 1 ) {
			$return = "checked";
		}

		return $return;
	}


	/**
	 * featured checkbox
	 *
	 * @return string
	 */
	public function checkPrivate()
	{
//dd('loaded');
		$return = '';

		$is_private = $this->entity->is_private;
//dd($navigation);
		if ( $is_private == 1 ) {
			$return = "checked";
		}

		return $return;
	}

	/**
	 * timed checkbox
	 *
	 * @return string
	 */
	public function isPrivate()
	{
//dd("loaded");
		$return = '';
		$is_private = $this->entity->is_private;

		if ( $is_private == 1 ) {
			$return = '<span class="glyphicon glyphicon-ok text-success"></span>';
		} else {
			$return = '<span class="glyphicon glyphicon-remove text-danger"></span>';
		}

		return $return;
	}

	/**
	 * timed checkbox
	 *
	 * @return string
	 */
	public function isNavigation()
	{
//dd("loaded");
		$return = '';
		$is_navigation = $this->entity->is_navigation;

		if ( $is_navigation == 1 ) {
			$return = '<span class="glyphicon glyphicon-ok text-success"></span>';
		} else {
			$return = '<span class="glyphicon glyphicon-remove text-danger"></span>';
		}

		return $return;
	}

	/**
	 * timed checkbox
	 *
	 * @return string
	 */
	public function isTimed()
	{
//dd("loaded");
		$return = '';
		$is_timed = $this->entity->is_timed;

		if ( $is_timed == 1 ) {
			$return = '<span class="glyphicon glyphicon-ok text-success"></span>';
		} else {
			$return = '<span class="glyphicon glyphicon-remove text-danger"></span>';
		}

		return $return;
	}


}
