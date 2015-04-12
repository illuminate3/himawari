<?php
namespace App\Modules\Himawari\Http\Domain\Repositories;

use App\Modules\Himawari\Http\Domain\Models\Content;

class ContentRepository extends BaseRepository {

	/**
	 * The Module instance.
	 *
	 * @var App\Modules\ModuleManager\Http\Domain\Models\Module
	 */
	protected $content;

	/**
	 * Create a new ModuleRepository instance.
	 *
   	 * @param  App\Modules\ModuleManager\Http\Domain\Models\Module $module
	 * @return void
	 */
	public function __construct(
		Content $content
		)
	{
		$this->model = $content;
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
		$content = $this->model->with('assets')->find($id);
//dd($content['assets']);
		return compact('content');
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

		if ($content->image != NULL) {
			$image = $content->image;
		} else {
			$image = null;
		}


		return compact('content', 'image');
	}

	/**
	 * Get all models.
	 *
	 * @return Illuminate\Support\Collection
	 */
	public function store($input)
	{
//dd($input);
		$this->model = new Content;
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
//dd($input['enabled']);
		$content = Content::find($id);
		$content->update($input);
	}


// Functions --------------------------------------------------

	public function getAssets($content_id)
	{
		$assets = DB::table('assets')
			->where('content_id', '=', $content_id)
			->get();
		return $assets;
	}

	public function attachContent($id, $page_id)
	{
//dd($page_id);
		$content = $this->model->find($id);
		$content->pages()->attach($page_id);
	}

	public function detachContent($id, $page_id)
	{
//dd($page_id);
		$content = $this->model->find($id)->pages()->detach();
	}

/*
public function syncContent($id, $page_id)
{
	$content = Content::find($id);

// this is not a proper array
	$content->pages()->sync($page_id);
}
*/

}
