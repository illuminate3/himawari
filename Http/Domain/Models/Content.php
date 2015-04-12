<?php
namespace App\Modules\Himawari\Http\Domain\Models;

use Illuminate\Database\Eloquent\Model;

//use App\Modules\Himawari\Http\Domain\Models\Asset;

use Laracasts\Presenter\PresentableTrait;

class Content extends Model {
//class Page extends \Kalnoy\Nestedset\Node {

	use PresentableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'contents';

	protected $presenter = 'App\Modules\Campus\Http\Presenters\Himawari';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
//	protected $hidden = ['password', 'remember_token'];

// DEFINE Rules --------------------------------------------------
	public static $rules = array(
/*
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `make` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
*/
	);

	public static $rulesUpdate = array(
/*
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `make` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
*/
	);


// DEFINE Fillable -------------------------------------------------------
/*
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `make` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
*/
	protected $fillable = [
		'id',
		'page_id',
		'make',
		'model',
		'model_number',
		'description',
		'image'
		];

// DEFINE Relationships --------------------------------------------------

	public function assets()
	{
		return $this->hasMany('App\Modules\Himawari\Http\Domain\Models\Asset');
	}

	public function page()
	{
		return $this->belongsTo('App\Modules\Himawari\Http\Domain\Models\Page');
	}

	public function pages()
	{
		return $this->belongsToMany('App\Modules\Himawari\Http\Domain\Models\Page', 'page_content', 'content_id', 'page_id');
	}

// 	public function assets()
// 	{
// 		return $this->belongsToMany('App\Modules\Himawari\Http\Domain\Models\Asset', 'asset_content', 'content_id', 'asset_id');
// 	}


// Functions --------------------------------------------------

	public function attachContent($id, $page_id)
	{
		$content = Content::find($id);
		$content->pages()->attach($page_id);
	}

	public function detachContent($id, $page_id)
	{
		$content = Content::find($id)->pages()->detach();
	}

/*
public function syncContent($id, $page_id)
{
	$content = Content::find($id);

// this is not a proper array
	$content->pages()->sync($page_id);
}
*/


/*
public function assets()
{
	return $this->hasMany('Asset');
}
public function pages()
{
	return $this->belongsToMany('Page');
//	return $this->belongsToMany('Page')->withPivot('page_content');
}

public function assets()
{
	return $this->belongsToMany('Asset');
}
*/


}
