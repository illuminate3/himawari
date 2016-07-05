<?php

namespace App\Modules\Himawari\Http\Models;

use Illuminate\Database\Eloquent\Model;

// use Cviebrock\EloquentSluggable\SluggableInterface;
// use Cviebrock\EloquentSluggable\SluggableTrait;

use Laracasts\Presenter\PresentableTrait;
//use AuraIsHere\LaravelMultiTenant\Traits\TenantScopedModelTrait;
use App\Modules\Core\Http\Traits\TenantableTrait;

use Vinkla\Translator\Translatable;
use Vinkla\Translator\Contracts\Translatable as TranslatableContract;

use Baum\Node;
use Cache;
use DB;

//class Content extends Node implements TranslatableContract, SluggableInterface {
class Content extends Node implements TranslatableContract {


	use PresentableTrait;
//	use SluggableTrait;
//	use TenantScopedModelTrait;
	use TenantableTrait;
	use Translatable;

	protected $table = 'contents';

// Presenter -------------------------------------------------------
	protected $presenter = 'App\Modules\Himawari\Http\Presenters\Himawari';

// Translation Model -------------------------------------------------------
	protected $translator = 'App\Modules\Himawari\Http\Models\ContentTranslation';

// DEFINE Hidden -------------------------------------------------------
	protected $hidden = [
		'created_at',
		'updated_at'
		];

// DEFINE Fillable -------------------------------------------------------
	protected $fillable = [
		'is_timed',
		'is_navigation',
		'order',
		'publish_start',
		'publish_end',
		'print_status_id',
		'user_id',
		// Translatable columns
		'meta_description',
		'meta_keywords',
		'meta_title',
		'class',
		'content',
		'slug',
		'summary',
		'title'
		];

// Sluggable Item -------------------------------------------------------
// 	protected $sluggable = [
// 		'build_from' => 'title',
// 		'save_to'    => 'slug',
// 	];

// Translated Columns -------------------------------------------------------
	protected $translatedAttributes = [
		'meta_description',
		'meta_keywords',
		'meta_title',
		'content',
		'slug',
		'summary',
		'title'
		];

// 	protected $appends = [
// 		'status',
// 		'title'
// 		];

	public function getContentAttribute()
	{
		return $this->content;
	}

	public function getSummaryAttribute()
	{
		return $this->summary;
	}

	public function getTitleAttribute()
	{
		return $this->title;
	}


// Relationships -----------------------------------------------------------

// hasOne
// hasMany
// belongsTo
// belongsToMany

	public function documents()
	{
		return $this->belongsToMany('App\Modules\Filex\Http\Models\Document', 'content_document');
	}

	public function images()
	{
		return $this->belongsToMany('App\Modules\Filex\Http\Models\Image', 'content_image');
	}

	public function sites()
	{
		return $this->belongsToMany('App\Modules\Core\Http\Models\Site', 'content_site');
	}


// Functions ---------------------------------------------------------------


	public static function getRoots()
	{
		// $roots = Cache::rememberForever('roots', function()
		// {
			$roots = static::whereIsCurrent(1)
							->whereIsOnline(1)
							->whereIsDeleted(0)
							->whereParentId(NULL)
// 							->where('slug', '<>', 'home-page')
// 							->where('slug', '<>', 'search')
// 							->where('slug', '<>', 'terms-conditions')
							->orderBy('order')
							->get();
		// });
//dd($roots);

		return $roots;
	}

	public static function getRootsSQL($locale_id)
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
//dd('here');
dd($page);

		return $page;
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

	public static function getRootsStatic()
	{
		// $roots = Cache::rememberForever('roots', function()
		// {
			return static::join('content_translations', 'contents.id', '=', 'content_translations.content_id')
							->whereIsCurrent(1)
							->whereIsOnline(1)
							->whereIsDeleted(0)
							->whereParentId(NULL)
//			->where('content_translations.locale_id', '=', $locale_id)
// 							->where('slug', '<>', 'home-page')
// 							->where('slug', '<>', 'search')
// 							->where('slug', '<>', 'terms-conditions')
							->orderBy('order')
							->get();
		// });

		// return $roots;
	}

	public static function getParentOptions($exceptId)
	{
//dd($exceptId);
dd(['0' => trans('kotoba::cms.no_parent')]
				+ static::whereIsDeleted(0)
				->lists('title', 'id'));

		return $exceptId
			? ['0' => trans('kotoba::cms.no_parent')]
				+ static::whereIsDeleted(0)
				->whereNotIn('id', [$exceptId])
				->lists('title', 'id')
			: ['0' => trans('kotoba::cms.no_parent')]
				+ static::whereIsDeleted(0)
				->lists('title', 'id');
	}

	public static function getPage( $slug )
	{
	   $page =  static::whereIsCurrent(1)
					   ->whereIsOnline(1)
					   ->whereIsDeleted(0)
					   ->whereSlug($slug)
					   ->first();

		return $page;
	}


// scopes

	public function scopeSiteID($query)
	{
//		return $query->where('site_id', '=', 11);
		$siteId = Cache::get('siteId');
//dd($siteId);
		return $query->whereHas('sites', function($query) use($siteId)
		{
			$query->where('sites.id', $siteId);
		});
	}


	public function scopeIsDraft($query)
	{
		return $query->where('print_status_id', '=', 1);
	}

	public function scopeIsPrivate($query)
	{
		return $query->where('is_private', '=', 1);
	}

	public function scopeIsNotPrivate($query)
	{
		return $query->where('is_private', '=', 0);
	}

	public function scopeInPrint($query)
	{
		return $query->where('print_status_id', '=', 2);
	}

	public function scopeIsArchived($query)
	{
		return $query->where('print_status_id', '=', 4);
	}

// 	public function scopeIsFeatured($query)
// 	{
// 		return $query->where('is_featured', '=', 1);
// 	}

	public function scopeIsTimed($query)
	{
//		return $query->where('is_timed', '=', 1);

		$date = date("Y-m-d");
		return $query
			->where('is_timed', '=', 1)
			->where('publish_start', '<=', $date . " 00:00:00")
			->where('publish_end', '>=', $date . " 23:59:59");

	}

// 	public function scopeNotFeatured($query)
// 	{
// 		return $query->where('is_featured', '=', 0);
// 	}

	public function scopeNotTimed($query)
	{
		return $query->where('is_timed', '=', 0);
	}

	public function scopePublishEnd($query)
	{
	//	$today = new DateTime();
	//dd($today);
		$date = date("Y-m-d");
	//dd($date);
	//	return $query->where('created_at', '>', $today->modify('-7 days'));
		return $query->where('publish_end', '>=', $date . " 23:59:59");
	}

	public function scopePublishStart($query)
	{
		$date = date("Y-m-d");
	//dd($date);
		return $query->where('publish_start', '<=', $date . " 00:00:00");
	}

	public function scopeIsAccessPoint($query)
	{
		return $query->where('class', '=', 'nav-access');
	}

	public function scopeIsNavigation($query)
	{
		return $query->where('is_navigation', '=', 1);
	}

}
