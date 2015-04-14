<?php
namespace App\Modules\Himawari\Http\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

// use DB;
// use Eloquent;
use URL;

//class Page extends Model {
class Page extends \Kalnoy\Nestedset\Node {

	use PresentableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pages';

	protected $presenter = 'App\Modules\Himawari\Http\Presenters\Himawari';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
//	protected $hidden = ['password', 'remember_token'];

// DEFINE Fillable -------------------------------------------------------
/*
  `user_id` int(10) unsigned NOT NULL,
  `print_status_id` tinyint(4) NOT NULL DEFAULT '0',
  `is_published` tinyint(4) NOT NULL DEFAULT '0',
  `is_featured` tinyint(4) NOT NULL DEFAULT '0',
  `publish_start` date DEFAULT NULL,
  `publish_end` date DEFAULT NULL,
  `page_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `summary` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
*/
//	protected $fillable = array('slug', 'title', 'parent_id');
	protected $fillable = [
		'id',
		'_lft',
		'_rgt',
		'parent_id',
		'user_id',
		'print_status_id',
		'is_published',
		'is_featured',
		'publish_start',
		'publish_end',
		'page_id',
		'locale',
		'slug',
		'title',
		'summary',
		'body',
		'meta_title',
		'meta_keywords',
		'meta_description',
		'uri',
		];


/**
 * The set of characters for testing slugs.
 *
 * @var  string
 */
	public static $slugPattern = '[a-z0-9\-/]+';


	protected $visible = array('title', 'slug', 'children');


// DEFINE Relationships --------------------------------------------------

	public function content()
	{
		return $this->hasOne('App\Modules\Himawari\Http\Domain\Models\Content');
	}

	public function contents()
	{
//		return $this->belongsToMany('App\Modules\Himawari\Http\Domain\Models\Content', 'content_page', 'content_id', 'page_id');
		return $this->belongsToMany('App\Modules\Himawari\Http\Domain\Models\Content', 'content_page', 'page_id', 'content_id');
	}

/*
public function contents()
{
	return $this->belongsToMany('Content');
}
public function assets()
{
	return $this->hasManyThrough('Asset', 'Content');
}
*/


// Functions --------------------------------------------------

    /**
     * Get the contents.
     *
     * @return \Kalnoy\Nestedset\Collection
     */
    public function getContents()
    {
        // The source of contents is the top page not including the root.
        $source = $this->parent_id == 1
            ? $this
            : $this->ancestors()->withoutRoot()->first();

        $contents = $source
            ->descendants()
            ->defaultOrder()
            ->get([ 'id', 'slug', 'title', static::LFT, 'parent_id' ])
//            ->get([ 'id', static::LFT, 'parent_id' ])
            ->toTree();

        return $contents;
    }

    /**
     * Get the page that is immediately after current page following the contents.
     *
     * @param array $columns
     *
     * @return Page|null
     */
    public function getNext(array $columns = array('slug', 'title', 'parent_id'))
    {
        $result = parent::getNext($columns);
//dd($result);
        return $result && $result->parent_id == 1 ? null : $result;
    }

    /**
     * Get the page that is immediately before current page following the contents.
     *
     * @param array $columns
     *
     * @return Page|null
     */
    public function getPrev(array $columns = array('slug', 'title', 'parent_id'))
    {
        if ($this->isRoot() || $this->parent_id == 1) return null;

        $result = parent::getPrev($columns);

        return $result && $result->parent_id == 1 ? null : $result;
    }

    /**
     * Get url for navigation.
     *
     * @return  string
     */
    public function getNavUrl()
    {
        return URL::route('page', array($this->attributes['slug']));
    }

    /**
     * Get navigation content label.
     *
     * @return  string
     */
    public function getNavLabel()
    {
        return $this->title;
    }

}
