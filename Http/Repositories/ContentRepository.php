<?php

namespace App\Modules\Himawari\Http\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

use App\Modules\Himawari\Http\Repositories\BaseRepository as BaseRepository;

use App\Modules\Core\Http\Repositories\LocaleRepository;

use App\Modules\Core\Http\Models\Locale;
use App\Modules\Himawari\Http\Models\Content;
use App\Modules\Himawari\Http\Models\ContentTranslation;

use App\Modules\Himawari\Events\ContentWasCreated;
use App\Modules\Himawari\Events\ContentWasUpdated;

use Illuminate\Support\Str;
use App;
use Auth;
use Cache;
use Config;
use DB;
use Lang;
use Route;
use Session;
use Shinobi;
use Input;

class ContentRepository extends BaseRepository {

	/**
	 * The Module instance.
	 *
	 * @var App\Modules\ModuleManager\Http\Models\Module
	 */
	protected $content;

	/**
	 * Create a new ModuleRepository instance.
	 *
   	 * @param  App\Modules\ModuleManager\Http\Models\Module $module
	 * @return void
	 */
	public function __construct(
			LocaleRepository $locale_repo,
			Content $content
		)
	{
		$this->locale_repo = $locale_repo;
		$this->model = $content;
	}


	/**
	 * Get role collection.
	 *
	 * @return Illuminate\Support\Collection
	 */
	public function create()
	{

		$lang = Session::get('locale');
		$locale_id = $this->locale_repo->getLocaleID($lang);
//dd($locale_id);

//		$pagelist = $this->getParents( $exceptId = $this->id, $locales );

// 		$pagelist = $this->getParents($locale_id, null);
// 		$pagelist = array('' => trans('kotoba::cms.no_parent')) + $pagelist;
//dd($pagelist);
		$all_pagelist = $this->getParents($locale_id, null);
		$pagelist = array('' => trans('kotoba::cms.no_parent'));
		$pagelist = new Collection($pagelist);
		$pagelist = $pagelist->merge($all_pagelist);


		$users = $this->getUsers();
		$users = array('' => trans('kotoba::general.command.select_a') . '&nbsp;' . Lang::choice('kotoba::account.user', 1) ) + $users;

		$print_statuses = $this->getPrintStatuses($locale_id);
		$print_statuses = array('' => trans('kotoba::general.command.select_a') . '&nbsp;' . Lang::choice('kotoba::cms.print_status', 1) ) + $print_statuses;

		$get_images = $this->getImages();

		$get_documents = $this->getDocuments();

		$get_sites = $this->getSites();
		$allSites = $this->getListSites();

		$user_id = Auth::user()->id;

		$default_publish_status = Config::get('himawri.default_publish_status', '1');


		return compact(
			'default_publish_status',
			'pagelist',
			'get_documents',
			'get_images',
			'get_sites',
			'allSites',
			'print_statuses',
			'users',
			'user_id',
			'lang',
			'locale_id'
			);
	}


	/**
	 * Get user collection.
	 *
	 * @param  string  $slug
	 * @return Illuminate\Support\Collection
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Get user collection.
	 *
	 * @param  int  $id
	 * @return Illuminate\Support\Collection
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Get all models.
	 *
	 * @return Illuminate\Support\Collection
	 */
	public function store($input)
	{
//dd($input);

		if ( !isset($input['class']) ) {
			$class = null;
		} else {
			$class = $input['class'];
		}

		if ( !isset($input['order']) ) {
			$order = 1;
		} else {
			$order = $input['order'];
		}

		if ( !isset($input['is_private']) ) {
			$is_private = 0;
		} else {
			$is_private = $input['is_private'];
		}

		if ( !isset($input['is_navigation']) ) {
			$is_navigation = 0;
		} else {
			$is_navigation = $input['is_navigation'];
		}

		if ( !isset($input['is_timed']) ) {
			$is_timed = 0;
		} else {
			$is_timed = $input['is_timed'];
		}

		if ( $input['publish_end'] == '' ) {
			$publish_end = null;
		} else {
			$publish_end = $input['publish_end'];
		}

		if ( $input['publish_start'] == '' ) {
			$publish_start = null;
		} else {
			$publish_start = $input['publish_start'];
		}

		if ( Auth::user()->is('super_admin') ) {
			$print_status_id = $input['print_status_id'];
		} else {
			$print_status_id = Config::get('himwarai.default_publish_status', '2');
		}

		$lang = Session::get('locale');
		$app_locale_id = $this->locale_repo->getLocaleID($lang);

//		$slug = Str::slug($input['title_'.$app_locale_id]);
//		$slug = Str::slug($input['slug_'.$app_locale_id]);

		$values = [
			'is_private'				=> $is_private,
			'is_timed'					=> $is_timed,
			'is_navigation'				=> $is_navigation,
			'class'						=> $class,
			'order'						=> $order,
			'print_status_id'			=> $print_status_id,
			'publish_end'				=> $publish_end,
			'publish_start'				=> $publish_start,
//			'slug'						=> $slug,
			'user_id'					=> $input['user_id']
		];
//dd($values);

		$content = Content::insert($values);

		$last_insert_id = DB::getPdo()->lastInsertId();
//		$last_insert_id = $this->getContentIDbySlug($slug);
//dd($last_insert_id);

		$contents = Content::find($last_insert_id);
//dd($contents);

		$locales = Cache::get('languages');
		$original_locale = Session::get('locale');

		foreach($locales as $locale => $properties)
		{

			App::setLocale($properties->locale);

			$values = [
				'content'				=> $input['content_'.$properties->id],
				'summary'				=> $input['summary_'.$properties->id],
				'title'					=> $input['title_'.$properties->id],
				'slug'					=> $input['slug_'.$properties->id],
				'meta_title'			=> $input['meta_title_'.$properties->id],
				'meta_keywords'			=> $input['meta_keywords_'.$properties->id],
				'meta_description'		=> $input['meta_description_'.$properties->id]
			];

			$contents->update($values);
		}

		$this->manageBaum($input['parent_id'], null);

		App::setLocale($original_locale, Config::get('app.fallback_locale'));


// TODO fix mulitple select documents
// 		$document_id = Input::get('document_id');
// 		if ( $document_id != null ) {
// 			$this->attachDocument($last_insert_id, $document_id);
// 		}
//dd($document_id);
//		$content = $this->content->find($last_insert_id);
		if ( isset($input['document_id']) ) {
			$contents->documents()->sync($input['document_id']);
		} else {
			$contents->documents()->detach();
		}
		if ( isset($input['sites_id']) ) {
			$contents->sites()->sync($input['sites_id']);
		} else {
			$contents->sites()->detach();
		}

		$image_id = Input::get('image_id');
		if ( $image_id != null ) {
			$this->attachImage($last_insert_id, $image_id);
		}

		$content_values = [
			'image_id'					=> $image_id
		];
		if ( $content_values != "" ) {
			$contents->update($content_values);
		}

		\Event::fire(new ContentWasCreated($contents));

		return;
	}


	/**
	 * Update a role.
	 *
	 * @param  array  $inputs
	 * @param  int    $id
	 * @return void
	 */
	public function update($input, $id)
	{
//dd($input);

		if ( !isset($input['class']) ) {
			$class = null;
		} else {
			$class = $input['class'];
		}

		if ( !isset($input['order']) ) {
			$order = 1;
		} else {
			$order = $input['order'];
		}

		if ( !isset($input['is_private']) ) {
			$is_private = 0;
		} else {
			$is_private = $input['is_private'];
		}

		if ( !isset($input['is_navigation']) ) {
			$is_navigation = 0;
		} else {
			$is_navigation = $input['is_navigation'];
		}

/*
		if ( !isset($input['is_timed']) ) {
			$is_timed = 0;
		} else {
			$is_timed = $input['is_timed'];
		}

		if ( $input['publish_end'] == '' ) {
			$publish_end = null;
		} else {
			$publish_end = $input['publish_end'];
		}

		if ( $input['publish_start'] == '' ) {
			$publish_start = null;
		} else {
			$publish_start = $input['publish_start'];
		}
*/
		if ( !isset($input['is_timed']) ) {
			$is_timed = 0;
			$publish_end = '0000-00-00';
			$publish_start = '0000-00-00';
		} else {
			$is_timed = $input['is_timed'];
			$publish_end = $input['publish_end'];
			$publish_start = $input['publish_start'];
		}

		if ( Auth::user()->is('super_admin') ) {
			$print_status_id = $input['print_status_id'];
		} else {
			$print_status_id = Config::get('himawari.default_publish_status', '1');
		}

		$content = Content::find($id);
//dd($content);

		$lang = Session::get('locale');
		$app_locale_id = $this->locale_repo->getLocaleID($lang);
//dd($locale_id);

//		$slug = Str::slug($input['title_'.$app_locale_id]);
//		$slug = Str::slug($input['slug_'.$app_locale_id]);

		$values = [
			'is_private'				=> $is_private,
			'is_timed'					=> $is_timed,
			'is_navigation'				=> $is_navigation,
			'class'						=> $class,
			'order'						=> $order,
			'print_status_id'			=> $print_status_id,
			'publish_end'				=> $publish_end,
			'publish_start'				=> $publish_start,
//			'slug'						=> $slug,
			'user_id'					=> $input['user_id']
		];

		$content->update($values);

		$locales = Cache::get('languages');
		$original_locale = Session::get('locale');

		foreach($locales as $locale => $properties)
		{

			App::setLocale($properties->locale);

			$values = [
				'content'				=> $input['content_'.$properties->id],
				'summary'				=> $input['summary_'.$properties->id],
				'slug'					=> $input['slug_'.$properties->id],
				'meta_title'			=> $input['meta_title_'.$properties->id],
				'meta_keywords'			=> $input['meta_keywords_'.$properties->id],
				'meta_description'		=> $input['meta_description_'.$properties->id]
			];

			$content->update($values);

		}

//dd($input['parent_id']);

		$this->manageBaum($input['parent_id'], $id);

		App::setLocale($original_locale, Config::get('app.fallback_locale'));

//dd($input['sites_id']);
//		$content = $this->content->find($id);
		if ( isset($input['document_id']) ) {
			$content->documents()->sync($input['document_id']);
		} else {
			$content->documents()->detach();
		}
		if ( isset($input['sites_id']) ) {
			$content->sites()->sync($input['sites_id']);
		} else {
			$content->sites()->detach();
		}

		\Event::fire(new ContentWasUpdated($content));

		return;
	}


// Functions ----------------------------------------------------------------------------------------------------


	public function attachDocument($id, $document_id)
	{
//dd($id);
		$content = $this->model->find($id);
		$content->documents()->attach($document_id);
	}

	public function detachDocument($id, $document_id)
	{
//dd($image_id);
		$document = $this->model->find($id)->documents()->detach();
	}


	public function attachImage($id, $image_id)
	{
//dd($image_id);
		$content = $this->model->find($id);
		$content->images()->attach($image_id);
	}

	public function detachImage($id, $image_id)
	{
//dd($image_id);
		$image = $this->model->find($id)->images()->detach();
	}


// get


	public function getContentIDbySlug($slug)
	{

		$id = DB::table('content_translations')
			->where('slug', '=', $slug)
			->pluck('id');

		return $id;
	}


	public function getImages()
	{
		$images = DB::table('images')->get();
		return $images;
	}

	public function getDocuments()
	{
		$documents = DB::table('documents')->get();
		return $documents;
	}


	public function getContentID($name)
	{

		$id = DB::table('contents')
			->where('name', '=', $name)
			->pluck('id');

		return $id;
	}

	public function getSiteName($site_id)
	{
		$site_name = DB::table('sites')
			->where('id', '=', $site_id)
			->pluck('name');
		return $site_name;
	}


//	public function getParents($exceptId, $locale)
	public function getParents($locale_id, $id)
	{
		if ($id != null ) {
			$query = Content::select('content_translations.title AS title', 'contents.id AS id')
				->join('content_translations', 'contents.id', '=', 'content_translations.content_id')
				->where('content_translations.locale_id', '=', $locale_id)
				->where('contents.id', '!=', $id, 'AND')
				->get();
		} else {
			$query = Content::select('content_translations.title AS title', 'contents.id AS id')
			->join('content_translations', 'contents.id', '=', 'content_translations.content_id')
			->where('content_translations.locale_id', '=', $locale_id)
			->get();
		}

		$parents = $query->lists('title', 'id');
//dd($parents);

		return $parents;
	}

	public function manageBaum($parent_id, $id)
	{
//dd($parent_id);

		if ($parent_id == "" ) {
			$parent_id = 0;
		}

		if ($parent_id != 0 && $id != null) {
			$node = Content::find($id);
			$node->makeChildOf($parent_id);
		}

		if ($parent_id == 0 && $id != null) {
			$node = Content::find($id);
			$node->makeRoot();
		}

	}

	public function getPageID($slug, $locale_id)
	{
//dd($slug);
/*
		$page_ID = DB::table('contents')
			->where('slug', '=', $slug)
			->pluck('id');
*/
		$page_ID = DB::table('content_translations')
			->where('content_translations.slug', '=', $slug)
			->where('content_translations.locale_id', '=', $locale_id)
			->pluck('content_id');
//dd($page_ID);

		return $page_ID;
	}


	public function getContent($page_ID)
	{
//dd($page_ID);
//dd(Auth::user());
		if ( Auth::user() ) {
//			$content = Content::find($page_ID);
			$content = Content::InPrint()->SiteID()->find($page_ID);
//dd($content);
		} else {
			$content = Content::InPrint()->SiteID()->IsNotPrivate()->find($page_ID);
//dd($content);
		}
//dd($content);

		return $content;
	}


	public function getPage($locale_id, $slug)
	{
//dd($slug);
		$page = DB::table('contents')
			->join('content_translations', 'contents.id', '=', 'content_translations.content_id')
			->where('content_translations.locale_id', '=', $locale_id)
//			->where('contents.is_current', '=', 1, 'AND')
			->where('contents.is_online', '=', 1, 'AND')
			->where('contents.is_deleted', '=', 0, 'AND')
//			->where('content_translations.slug', '=', $slug, 'AND')
			->where('contents.slug', '=', $slug, 'AND')
			->pluck('contents.id');
//dd($page);

 		$content = Content::find($page);
dd($content);

/*
	   $page =  static::whereIsCurrent(1)
					   ->whereIsOnline(1)
					   ->whereIsDeleted(0)
					   ->whereSlug($slug)
					   ->first();
*/
		return $page;
	}


	public function getRoots($locale_id)
	{
		// $roots = Cache::rememberForever('roots', function()
		// {
		$page = DB::table('contents')
			->join('content_translations', 'contents.id', '=', 'content_translations.content_id')
			->where('content_translations.locale_id', '=', $locale_id)
			->where('contents.is_online', '=', 1, 'AND')
			->where('contents.is_deleted', '=', 0, 'AND')
			->where('contents.parent_id', '=', null, 'AND')
//			->where('content_translations.slug', '=', $slug, 'AND')
//			->first();
			->orderBy('order')
			->get();
//dd($page);

/*
			return static::whereIsCurrent(1)
							->whereIsOnline(1)
							->whereIsDeleted(0)
							->whereParentId(NULL)
							->where('slug', '<>', 'home-page')
							->where('slug', '<>', 'search')
							->where('slug', '<>', 'terms-conditions')
							->orderBy('order')
							->get();
*/
		// });

		// return $roots;
	}


	public static function getStaticRoots($locale_id)
	{
		// $roots = Cache::rememberForever('roots', function()
		// {
		$page = DB::table('contents')
			->join('content_translations', 'contents.id', '=', 'content_translations.content_id')
			->where('content_translations.locale_id', '=', $locale_id)
			->where('contents.is_online', '=', 1, 'AND')
			->where('contents.is_deleted', '=', 0, 'AND')
			->where('contents.parent_id', '=', null, 'AND')
//			->where('content_translations.slug', '=', $slug, 'AND')
//			->first();
			->orderBy('order')
			->get();
//dd($page);
		return $page;
	}

	public function getUsers()
	{
		$users = DB::table('users')->lists('email', 'id');
		return $users;
	}

	public function getPrintStatuses($locale_id)
	{
//		$print_statuses = DB::table('prints')->lists('name', 'id');
//dd($print_statuses);
/*
		$print_statuses = DB::table('print_statuses')
			->join('print_statuses', 'print_statuses.id', '=', 'print_status_translations.print_status_id')
			->where('print_status_translations.locale_id', '=', $locale_id)
			->orderBy('print_status_translations.id')
			->get();
*/
		$print_statuses = DB::table('print_status_translations')
			->where('locale_id', '=', $locale_id)
			->orderBy('id')
			->lists('name', 'id');

		return $print_statuses;
	}

// 	public function makeSlugFromTitle($title)
// 	{
// 		$slug = Str::slug($title);
// 		$count = ContentTranslation::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
//
// 		return $count ? "{$slug}-{$count}" : $slug;
// 	}

	public function getSites()
	{
		$sites = DB::table('sites')->get();
		return $sites;
	}

	public function getListSites()
	{
//		$sites = DB::table('sites')->lists('name', 'id');
		$sites = DB::table('sites')
			->where('status_id', '=', 1)
			->lists('name', 'id');

		return $sites;
	}

	public function getListDocuments()
	{
		$documents = DB::table('documents')->lists('document_file_name', 'id');
		return $documents;
	}


}
