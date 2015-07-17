<?php

namespace App\Modules\Himawari\Http\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

use App\Modules\Himawari\Http\Repositories\BaseRepository as BaseRepository;

use App\Modules\General\Http\Models\Locale;
use App\Modules\Himawari\Http\Models\Content;
use App\Modules\Himawari\Http\Models\ContentTranslation;

use App;
use Auth;
use Config;
use DB;
use Lang;
use Route;
use Session;
use Illuminate\Support\Str;


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
		Content $content
		)
	{
		$this->model = $content;

		$this->id = Route::current()->parameter( 'id' );
//		$this->pagelist = Page::getParentOptions( $exceptId = $this->id );
//		$this->pagelist = Content::getParentOptions( $exceptId = $this->id );
//dd($this->pagelist);
	}


	/**
	 * Get role collection.
	 *
	 * @return Illuminate\Support\Collection
	 */
	public function create()
	{
		$lang = Session::get('locale');
		$locales = $this->getLocales();
		$locale_id = $this->getLocaleID($lang);
//dd($locales);
//		$pagelist = $this->getParents( $exceptId = $this->id, $locales );

		$pagelist = $this->getParents($locale_id, null);
		$pagelist = array('' => trans('kotoba::cms.no_parent')) + $pagelist;
//dd($pagelist);

		$users = $this->getUsers();
		$users = array('' => trans('kotoba::general.command.select_a') . '&nbsp;' . Lang::choice('kotoba::account.user', 1) ) + $users;
//dd($users);
		$print_statuses = $this->getPrintStatuses($locale_id);
		$print_statuses = array('' => trans('kotoba::general.command.select_a') . '&nbsp;' . Lang::choice('kotoba::cms.print_status', 1) ) + $print_statuses;

		$user_id = Auth::user()->id;

		return compact(
			'lang',
			'locales',
			'pagelist',
			'print_statuses',
			'users',
			'user_id'
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
		$content = $this->model->find($id);
		$links = Content::find($id)->contentlinks;
//$content = $this->content->show($id);

//$content = $this->model->where('id', $id)->first();
//		$content = new Collection($content);
//dd($content);

		return compact('content', 'links');
	}


	/**
	 * Get user collection.
	 *
	 * @param  int  $id
	 * @return Illuminate\Support\Collection
	 */
	public function edit($id)
	{
		$content = $this->model->find($id);
//dd($content);

		$lang = Session::get('locale');
		$locales = $this->getLocales();
		$locale_id = $this->getLocaleID($lang);
//dd($locales);
//		$pagelist = $this->getParents( $exceptId = $this->id, $locales );

		$pagelist = $this->getParents($locale_id, $id);
		$pagelist = array('' => trans('kotoba::cms.no_parent')) + $pagelist;
//dd($pagelist);

		$users = $this->getUsers();
		$users = array('' => trans('kotoba::general.command.select_a') . '&nbsp;' . Lang::choice('kotoba::account.user', 1) ) + $users;
//dd($users);
		$print_statuses = $this->getPrintStatuses($locale_id);
		$print_statuses = array('' => trans('kotoba::general.command.select_a') . '&nbsp;' . Lang::choice('kotoba::cms.print_status', 1) ) + $print_statuses;

//		$user_id = Auth::user()->id;

		return compact(
			'content',
			'lang',
			'locales',
			'pagelist',
			'print_statuses',
			'users'
			);
	}


	/**
	 * Get all models.
	 *
	 * @return Illuminate\Support\Collection
	 */
	public function store($input)
	{
//dd($input);

		if ( !isset($input['is_featured']) ) {
			$is_featured = 0;
		} else {
			$is_featured = $input['is_featured'];
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
		if ( ($input['print_status_id'] == 3 || $input['print_status_id'] == 4) ) {
			$is_published = 1;
		}

		$values = [
//			'name'			=> $input['name'],
//			'is_current'		=> 1,
//			'is_online'			=> $input['is_online'],
//			'is_online'			=> $is_online,
//			'is_featured'		=> $input['is_featured'],
			'is_published'		=> $is_published,
			'is_featured'		=> $is_featured,
			'is_timed'			=> $is_timed,
			'link'				=> $input['link'],
			'order'				=> $input['order'],
			'print_status_id'	=> $input['print_status_id'],
//			'publish_end'		=> $input['publish_end'],
//			'publish_start'		=> $input['publish_start'],
			'publish_end'		=> $publish_end,
			'publish_start'		=> $publish_start,
			'slug'				=> $input['title_1'],
//			'user_id'			=> 1
			'user_id'			=>  $input['user_id']
		];
//dd($values);

		$content = Content::create($values);

		$locales = $this->getLocales();

		foreach($locales as $locale => $properties)
		{
			App::setLocale($properties['locale']);

/*
			if ( !isset($input['status_'.$properties['id']]) ) {
				$status = 0;
			} else {
				$status = $input['status_'.$properties['id']];
			}
*/

			$values = [
				'content'		=> $input['content_'.$properties['id']],
				'summary'		=> $input['summary_'.$properties['id']],
				'title'			=> $input['title_'.$properties['id']],

//				'slug'			=> $input['slug_'.$properties['id']],
//				'slug'			=> Str::slug($input['title_'.$properties['id']]),

				'meta_title'			=> $input['meta_title_'.$properties['id']],
				'meta_keywords'			=> $input['meta_keywords_'.$properties['id']],
				'meta_description'		=> $input['meta_description_'.$properties['id']]
			];

			$content->update($values);
		}

		$this->manageBaum($input['parent_id'], null);

		App::setLocale(Session::get('locale'), Config::get('app.fallback_locale'));
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

		if ( !isset($input['is_featured']) ) {
			$is_featured = 0;
		} else {
			$is_featured = $input['is_featured'];
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
		if ( ($input['print_status_id'] == 3 || $input['print_status_id'] == 4) ) {
			$is_published = 1;
		}

		$content = Content::find($id);

		$values = [
//			'name'			=> $input['name'],
//			'is_current'		=> 1,
//			'is_online'			=> $input['is_online'],
//			'is_online'			=> $is_online,
//			'is_featured'		=> $input['is_featured'],
			'is_published'		=> $is_published,
			'is_featured'		=> $is_featured,
			'is_timed'			=> $is_timed,
			'link'				=> $input['link'],
			'order'				=> $input['order'],
			'print_status_id'	=> $input['print_status_id'],
//			'publish_end'		=> $input['publish_end'],
//			'publish_start'		=> $input['publish_start'],
			'publish_end'		=> $publish_end,
			'publish_start'		=> $publish_start,
			'slug'				=> $input['title_1'],
//			'user_id'			=> 1
			'user_id'			=>  $input['user_id']
		];

		$content->update($values);

		$locales = $this->getLocales();

		foreach($locales as $locale => $properties)
		{
			App::setLocale($properties['locale']);

			$values = [
				'content'		=> $input['content_'.$properties['id']],
				'summary'		=> $input['summary_'.$properties['id']],
				'title'			=> $input['title_'.$properties['id']],

//				'slug'			=> $input['slug_'.$properties['id']],
//				'slug'			=> Str::slug($input['title_'.$properties['id']]),
//'slug'			=> $this->makeSlugFromTitle($input['title_'.$properties['id']]),


				'meta_title'			=> $input['meta_title_'.$properties['id']],
				'meta_keywords'			=> $input['meta_keywords_'.$properties['id']],
				'meta_description'		=> $input['meta_description_'.$properties['id']]
			];

			$content->update($values);
		}

		$this->manageBaum($input['parent_id'], $id);

		App::setLocale(Session::get('locale'), Config::get('app.fallback_locale'));
		return;
	}



// Functions ----------------------------------------------------------------------------------------------------


	public function getLocales()
	{
		$locales = Locale::all();
		return $locales;
	}

	public function getLocaleID($lang)
	{

		$locale_id = DB::table('locales')
			->where('locale', '=', $lang)
			->pluck('id');

		return $locale_id;
	}


	public function getContentID($name)
	{

		$id = DB::table('contents')
			->where('name', '=', $name)
			->pluck('id');

		return $id;
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

		if ($parent_id != 0 && $id != null) {
			$node = Content::find($id);
			$node->makeChildOf($parent_id);
		}

		if ($parent_id == 0 && $id != null) {
			$node = Content::find($id);
			$node->makeRoot();
		}

	}


	public function getPageID($slug)
	{
//dd($slug);
/*
		$page_ID = DB::table('content_translations')
			->where('content_translations.slug', '=', $slug)
			->pluck('content_id');
*/
		$page_ID = DB::table('contents')
			->where('slug', '=', $slug)
			->pluck('id');
//dd($page_ID);

		return $page_ID;
	}


	public function getContent($page_ID)
	{
//dd($page_ID);
 		$content = Content::find($page_ID);
/*
		$page = DB::table('contents')
			->join('content_translations', 'contents.id', '=', 'content_translations.content_id')
			->where('content_translations.locale_id', '=', $locale_id)
//			->where('contents.is_current', '=', 1, 'AND')
			->where('contents.is_online', '=', 1, 'AND')
			->where('contents.is_deleted', '=', 0, 'AND')
			->where('content_translations.slug', '=', $slug, 'AND')
			->pluck('contents.id');
*/
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


}