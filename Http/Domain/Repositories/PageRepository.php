<?php
namespace App\Modules\Himawari\Http\Domain\Repositories;

use App\Modules\Himawari\Http\Domain\Models\Page;

//class PageRepository extends \Kalnoy\Nestedset\Node {
class PageRepository extends BaseRepository {

	/**
	 * The Module instance.
	 *
	 * @var App\Modules\ModuleManager\Http\Domain\Models\Module
	 */
	protected $page;

	/**
	 * Create a new ModuleRepository instance.
	 *
   	 * @param  App\Modules\ModuleManager\Http\Domain\Models\Module $module
	 * @return void
	 */
	public function __construct(
		Page $page
		)
	{
		$this->model = $page;
	}

	/**
	 * Get role collection.
	 *
	 * @return Illuminate\Support\Collection
	 */
	public function create()
	{
//		$allPermissions =  $this->permission->all()->lists('name', 'id');
//dd($allPermissions);

		return compact('');
	}

	/**
	 * Get user collection.
	 *
	 * @param  string  $slug
	 * @return Illuminate\Support\Collection
	 */
	public function show($id)
	{
		$page = $this->model->find($id);
//dd($module);

		return compact('page');
	}

	/**
	 * Get user collection.
	 *
	 * @param  int  $id
	 * @return Illuminate\Support\Collection
	 */
	public function edit($id)
	{
		$page = $this->model->find($id);
dd($id);

		return compact('page');
	}

	/**
	 * Get all models.
	 *
	 * @return Illuminate\Support\Collection
	 */
	public function store($input)
	{
//dd($input);
		$this->model = new Page;
		$this->model->create($input);
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
//dd('here');
//dd($input);
		$page = Page::find($id);
		$page->update($input);
	}


// Functions --------------------------------------------------

	/**
	* Apply some processing for an input.
	*
	* @param  array  $data
	*
	* @return array
	*/
	public function preprocessData(array $data)
	{
	if (isset($data['slug'])) $data['slug'] = strtolower($data['slug']);

	return $data;
	}


	/**
	 * Get all available nodes as a list for HTML::select.
	 *
	 * @return array
	 */
	public function getParents()
	{
//		$all = $this->model->select('id', 'title')->withDepth()->defaultOrder()->get();
		$all = $this->model->select('id')->withDepth()->defaultOrder()->get();
		$result = array();
//dd($all);

		foreach ($all as $content)
		{
			$title = $content->title;

			if ($content->depth > 0) $title = str_repeat('—', $content->depth).' '.$title;

			$result[$content->id] = $title;
		}

		return $result;
	}

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
dd($source);
        $contents = $source
            ->descendants()
            ->defaultOrder()
            ->get([ 'id', 'slug', 'title', static::LFT, 'parent_id' ])
            ->toTree();

        return $contents;
    }

}
