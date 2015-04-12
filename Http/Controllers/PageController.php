<?php
namespace App\Modules\Himawari\Http\Controllers;

use App\Modules\Himawari\Http\Domain\Models\Page;
use App\Modules\Himawari\Http\Domain\Repositories\PageRepository;

use Illuminate\Http\Request;
use App\Modules\Himawari\Http\Requests\DeleteRequest;
use App\Modules\Himawari\Http\Requests\PageCreateRequest;
use App\Modules\Himawari\Http\Requests\PageUpdateRequest;

use Illuminate\Support\Collection;
//use Kalnoy\Nestedset\Collection;

use App;
use Datatables;
use DB;
use Flash;

class PageController extends HimawariController {

//	protected $layout = 'layouts.master';

	/**
	 * The page storage.
	 *
	 * @var  Page
	 */
	protected $page;

	public function __construct(
		Page $page,
		PageRepository $pageRepo
		)
	{
		$this->page = $page;
		$this->pageRepo = $pageRepo;
// middleware
		$this->middleware('auth');
		$this->middleware('admin');
	}

	/**
	 * Display a page with given slug.
	 *
	 * @param   string  $slug
	 *
	 * @return  mixed
	 */
	public function show($slug = '/')
	{
//		$page = $this->page->whereSlug($slug)->first();
		$page = $this->page->with('contents')->whereSlug($slug)->first();
//dd($page);

		if ($page === null)
		{
			App::abort(404, trans('kotoba::general.error.page'));
		}

		$view = $page->isRoot() ? 'himawari::pages.pages_index' : 'himawari::pages.page';
//dd($view);
		$breadcrumbs = $this->getBreadcrumbs($page);
//dd($breadcrumbs);
		$menu = $this->getMenu($page);
//		$menu = $this->page->getMenu($page);
//dd($menu);
 		$mainMenu = $this->getMenu2($page);
//dd($mainMenu);

		return View($view, compact(
			'breadcrumbs',
			'page',
			'menu',
			'mainMenu'
			));


//         $this->layout->title = $page->title;
//         $this->layout->content = View::make($view, compact('page'));
//         $this->layout->menu = $this->getMenu($page);
// $this->layout->mainMenu = $this->getMenu2($page);
//        $this->layout->breadcrumbs = $this->getBreadcrumbs($page);
	}

	/**
	 * Get breadcrumbs to the current page.
	 *
	 * $active is the last crumb (the page title by default).
	 *
	 * @param   Page    $page
	 * @param   string  $active
	 * @param 	string  $route
	 *
	 * @return  array
	 */
	protected function getBreadcrumbs(Page $page, $active = null, $route = 'page')
	{
		if ($page->isRoot()) return array();

		$breadcrumbs['Index'] = url('/');
		$ancestors = $page
			->ancestors()
			->withoutRoot()
			->get(array('id', 'title', 'slug'));

		if ($active !== null) $ancestors->push($page);

		foreach ($ancestors as $content)
		{
			$breadcrumbs[$content->title] = route($route, array($content->slug));
		}

		$breadcrumbs[] = $active !== null ? $active : $page->title;

		return $breadcrumbs;
	}


	/**
	 * Get main menu contents.
	 *
	 * @param Page $activePage
	 *
	 * @return array
	 */
	public function getMenu($activePage)
	{

$results = Page::get();
$tree = $results->toTree();
//dd($tree);
//		$contentTree = $this->page
// 		$contentTree = DB::table('pages')
// 			->where('parent_id', '=', 1)
// 			->get([ 'id', 'slug', 'title', '_lft', 'parent_id' ])
// 			->toTree();
// dd($contentTree);
		return $this->make_nav($tree, $activePage->getKey());
	}


	public function getMenu2(Page $activePage)
	{
		$contentTree = $this->page
//		$contentTree = DB::table('pages')
			->where('parent_id', '!=', 'NULL')
			->get([ 'id', 'slug', 'title', '_lft', 'parent_id' ])
			->toTree();

		return $this->make_nav($contentTree, $activePage->getKey());
	}


	/**
	 * Convert tree of nodes in an array appropriate for HTML::nav().
	 *
	 * @param  \Illuminate\Support\Collection $tree
	 * @param  int         $activeContentKey
	 * @param  boolean     $active
	 *
	 * @return array
	 */
	public function make_nav(Collection $tree, $activeContentKey = null, &$active = null)
	{
		if (!$tree->count()) return null;

		return array_map(function ($content) use ($activeContentKey, &$active) {
			$data = array();

			$childActive = false;
			$data['contents'] = $this->make_nav($content->children, $activeContentKey, $childActive);

			if ($activeContentKey !== null)
			{
				$childActive |= $activeContentKey == $content->getKey();
			}

			$active |= $childActive;

			$data['active'] = $childActive;

			foreach (array('url', 'label') as $key) {
				$getter = 'getNav'.ucfirst($key);

				$data[$key] = $content->$getter();
			}

			return $data;

		}, $tree->all());
	}



}
