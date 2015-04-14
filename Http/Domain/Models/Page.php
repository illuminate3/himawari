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
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `_lft` int(10) unsigned NOT NULL,
  `_rgt` int(10) unsigned NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
*/
//	protected $fillable = array('slug', 'title', 'parent_id');
	protected $fillable = [
		'id',
		'slug',
		'title',
		'_lft',
		'_rgt',
		'parent_id'
		];


/**
 * The set of characters for testing slugs.
 *
 * @var  string
 */
	public static $slugPattern = '[a-z0-9\-/]+';


//	protected $visible = array('title', 'slug', 'children');


// DEFINE Relationships --------------------------------------------------

	public function content()
	{
		return $this->belongsTo('App\Modules\Himawari\Http\Domain\Models\Content');
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
	 * Apply some processing for an input.
	 *
	 * @param  array  $data
	 *
	 * @return array
	 */
// 	public function preprocessData(array $data)
// 	{
// 		if (isset($data['slug'])) $data['slug'] = strtolower($data['slug']);
//
// 		return $data;
// 	}

    /**
     * Perform validation.
     *
     * @return \Illuminate\Support\MessageBag|true
     */
//     public function validate()
//     {
//         $v = Validator::make($this->attributes, $this->getRules());
//
//         return $v->fails() ? $v->messages() : true;
//     }

    /**
     * Get validation rules.
     *
     * @return array
     */
//     public function getRules()
//     {
//         $rules = array(
//             'title' => 'required',
//
//             'slug'  => array(
//                 'required',
//                 'regex:#^'.self::$slugPattern.'$#',
//                 'unique:pages'.($this->exists ? ',slug,'.$this->id : ''),
//             ),
//
// //            'body'  => 'required',
//         );
//
//         if ($this->exists && ! $this->isRoot())
//         {
//             $rules['parent_id'] = 'required|exists:pages,id';
//         }
//
//         return $rules;
//     }

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
//            ->get([ 'id', 'slug', 'title', static::LFT, 'parent_id' ])
            ->get([ 'id', static::LFT, 'parent_id' ])
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
dd($result);
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
