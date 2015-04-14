<?php
namespace App\Modules\Himawari\Http\Controllers;

use App\Modules\Himawari\Http\Domain\Models\Page;
use App\Modules\Himawari\Http\Domain\Repositories\PageRepository;

use Illuminate\Http\Request;
use App\Modules\Himawari\Http\Requests\DeleteRequest;
use App\Modules\Himawari\Http\Requests\PageCreateRequest;
use App\Modules\Himawari\Http\Requests\PageUpdateRequest;

use App;
use Datatables;
use Flash;
use Input;

use dflydev\markdown\MarkdownParser;

class PagesController extends HimawariController {
//class PagesController extends \Kalnoy\Nestedset\Node {

//	protected $layout = 'layouts.backend';

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
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$pages = $this->page->withDepth()->defaultOrder()->get();
// dd($pages);
		return View('himawari::pages.index', compact('pages'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$parents = $this->pageRepo->getParents();
//		$parents = $this->pageRepo->getParents()->with('contents');
//dd($parents);
		return View('himawari::pages.create', compact('parents'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(
		PageCreateRequest $request
		)
	{
dd($request);

 		$data = $this->pageRepo->preprocessData($request->all());

/*
      "title" => "Index"
      "summary" => ""
      "body" => ""
      "user_id" => ""
      "print_status_id" => ""
      "is_published" => ""
      "is_featured" => ""
      "publish_start" => ""
      "publish_end" => ""
      "locale" => ""
      "uri" => ""
      "meta_title" => ""
      "meta_keywords" => ""
      "meta_description" => ""
      "slug" => "/"
*/


		$this->pageRepo->store($data);

		Flash::success( trans('kotoba::cms.success.page_create') );
		return redirect('pages');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
//dd($id);
		$modal_title = trans('kotoba::general.command.delete');
		$modal_body = trans('kotoba::general.ask.delete');
		$modal_route = 'pages.destroy';
		$modal_id = $id;
		$model = '$page';

		$page = $this->page->findOrFail($id);
//dd($page);
		$parents = $this->pageRepo->getParents();
//dd($parents);

		return View('himawari::pages.edit',
			$this->page->findOrFail($id),
				compact(
					'modal_title',
					'modal_body',
					'modal_route',
					'modal_id',
					'model',
					'page',
					'parents'
			));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(
		PageUpdateRequest $request,
		$id
		)
	{
//dd($request);
		$this->pageRepo->update($request->all(), $id);

		Flash::success( trans('kotoba::cms.success.page_update') );
		return redirect('pages');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$page = $this->page->findOrFail($id);

		$response = Redirect::route('pages.index');

		if ($page->delete())
		{
			$response->withSuccess('The page has been destroyed!');
		}
		else
		{
			$response->withWarning('The page was not destroyed.');
		}

		return $response;
	}

	/**
	 * Move the specified page up.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function up($id)
	{
//dd('up');
		return $this->move($id, 'before');
	}

	/**
	 * Move the specified page down.
	 *
	 * @param  int $id
	 *
	 * @return Response
	 */
	public function down($id)
	{
//dd('down');
		return $this->move($id, 'after');
	}

	/**
	 * Move the page.
	 *
	 * @param  int $id
	 * @param  'before'|'after' $dir
	 *
	 * @return Response
	 */
	protected function move($id, $dir)
	{
//dd($id);
		$page = $this->page->find($id);
		$sibling = $dir === 'before' ? $page->getPrevSibling() : $page->getNextSibling();
//dd($sibling);

		if ($sibling)
		{
			$page->$dir($sibling)->save();

			if ($page->hasMoved())
			{
				Flash::success( trans('kotoba::cms.success.page_move') );
				return redirect('pages');
			}
		}
		Flash::error( trans('kotoba::cms.error.page_move') );
		return redirect('pages');
	}

	/**
	 * Export pages.
	 *
	 * @return Response
	 */
	public function export()
	{
		$exporter = App::make('PagesExporter');
		$path = storage_path('tmp/pages.tmp');

		if ($exporter->export($path))
		{
			$headers = array('Content-Type' => $exporter->getMimeType());
			$fileName = 'pages.'.$exporter->getExtension();

			return Response::download($path, $fileName, $headers);
		}

		return Redirect::route('pages.index')->withError('Failed to export pages.');
	}

	/**
	 * Get all available nodes as a list for HTML::select.
	 *
	 * @return array
	 */
// 	protected function getParents()
// 	{
// 		$all = $this->page->select('id', 'title')->withDepth()->defaultOrder()->get();
// 		$result = array();
//
// 		foreach ($all as $content)
// 		{
// 			$title = $content->title;
//
// 			if ($content->depth > 0) $title = str_repeat('—', $content->depth).' '.$title;
//
// 			$result[$content->id] = $title;
// 		}
//
// 		return $result;
// 	}


}
