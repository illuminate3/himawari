<?php
namespace App\Modules\Himawari\Http\Controllers;

use App\Modules\Himawari\Http\Domain\Models\Page;
use App\Modules\Himawari\Http\Domain\Repositories\PageRepository;
use App\Modules\Himawari\Http\Domain\Models\Content;
use App\Modules\Himawari\Http\Domain\Repositories\ContentRepository;

use Illuminate\Http\Request;
use App\Modules\Himawari\Http\Requests\DeleteRequest;
use App\Modules\Himawari\Http\Requests\PageCreateRequest;
use App\Modules\Himawari\Http\Requests\PageUpdateRequest;
use App\Modules\Himawari\Http\Requests\ContentCreateRequest;
use App\Modules\Himawari\Http\Requests\ContentUpdateRequest;

use Datatables;
use Flash;
use Input;

class ContentsController extends HimawariController {

	/**
	 * Content Repository
	 *
	 * @var Content
	 */
	protected $content;

	public function __construct(
		Content $content,
		ContentRepository $contentRepo,
		Page $page,
		PageRepository $pageRepo
		)
	{
		$this->page = $page;
		$this->pageRepo = $pageRepo;
		$this->content = $content;
		$this->contentRepo = $contentRepo;
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
//		$contents = $this->contentRepo->all();
//		$contents = $contents->with('pages');
//dd($contents);
		return View('himawari::contents.index');
//		return View::make('contents.index', compact('contents'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
//		$parents = $this->getParents();
		$parents = $this->pageRepo->getParents();
//dd($parents);

//		return View::make('contents.create');
		return View('himawari::contents.create', compact('parents'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(
		ContentCreateRequest $request
		)
	{
		$this->contentRepo->store($request->all());

$id = DB::getPdo()->lastInsertId();

$content_id = Input::get('page_id');
$this->contentRepo->attachContent($id, $content_id);

		Flash::success( trans('kotoba::cms.success.content_create') );
		return redirect('admin/contents');
	}
// 	public function store1111()
// 	{
// //		$input = Input::all();
// 		$input = array_except(Input::all(), '_method');
// //dd($input);
//
// 		$validation = Validator::make($input, Content::$rules);
//
// 		if ($validation->passes())
// 		{
// 			$this->contentRepo->create($input);
//
//
// $id = DB::getPdo()->lastInsertId();
// $page_id = Input::get('page_id');
// $this->contentRepo->attachContent($id, $page_id);
//
//
// 			return Redirect::route('contents.index');
// 		}
//
// 		return Redirect::route('contents.create')
// 			->withInput()
// 			->withErrors($validation)
// 			->with('message', 'There were validation errors.');
// 	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
//dd("show");
//		$assets = $this->contentRepo->getAssets($content_id);
// 		$content = $this->content->find($id);

		$modal_title = trans('kotoba::general.command.delete');
		$modal_body = trans('kotoba::general.ask.delete');
		$modal_route = 'contents.destroy';
		$modal_id = $id;
		$model = '$content';

// 		return View('himawari::contents.show',
// 			compact(
// 				'assets',
// 				'content',
// 				'modal_title',
// 				'modal_body',
// 				'modal_route',
// 				'modal_id',
// 				'model'
// 			));

		return View('himawari::contents.show',
			$this->contentRepo->show($id),
//			$this->content->with('assets')->find($id),
				compact(
					'modal_title',
					'modal_body',
					'modal_route',
					'modal_id',
					'model'
			));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
// 		$page = $this->page->find($id);
// dd($page);
		$parents = $this->pageRepo->getParents();
//dd($parents);

		$modal_title = trans('kotoba::general.command.delete');
		$modal_body = trans('kotoba::general.ask.delete');
		$modal_route = 'admin.contents.destroy';
		$modal_id = $id;
		$model = '$content';

		return View('himawari::contents.edit',
			$this->contentRepo->edit($id),
				compact(
					'page',
					'parents',
					'modal_title',
					'modal_body',
					'modal_route',
					'modal_id',
					'model'
			));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(
		ContentUpdateRequest $request,
		$id
		)
	{
//dd("update");
		$this->contentRepo->update($request->all(), $id);

		$page_id = Input::get('page_id');
		$this->contentRepo->detachContent($id, $page_id);
		$this->contentRepo->attachContent($id, $page_id);

		Flash::success( trans('kotoba::cms.success.content_update') );
		return redirect('admin/contents');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->contentRepo->find($id)->delete();

		return Redirect::route('contents.index');
	}


// 	/**
// 	 * Get all available nodes as a list for HTML::select.
// 	 *
// 	 * @return array
// 	 */
// 	protected function getParents()
// 	{
// 		$all = $this->pageRepo->select('id', 'title')->withDepth()->defaultOrder()->get();
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

	/**
	* Datatables data
	*
	* @return Datatables JSON
	*/
	public function data()
	{
//		$query = Content::select(array('contents.id','contents.name','contents.description'))
//			->orderBy('contents.name', 'ASC');
//		$query = Content::select('id', 'name' 'description', 'updated_at');
//			->orderBy('name', 'ASC');
//		$query = Content::select('id', 'page_id', 'make', 'model', 'model_number', 'description');

		$query = Content::select([
			'contents.id', 'contents.make', 'contents.model', 'contents.model_number', 'contents.description',
			'pages.title'
		])
		->leftJoin('pages','pages.id','=','contents.page_id');
//dd($query);

		return Datatables::of($query)
//			->remove_column('id')

// 			-> edit_column(
// 				'division_id',
// 				'{{ $query->present()->divisionName(division_id) }}'
// 				)

			->addColumn(
				'actions',
				'
					<a href="{{ URL::to(\'admin/contents/\' . $id . \'/\' ) }}" class="btn btn-info btn-sm" >
						<span class="glyphicon glyphicon-search"></span>  {{ trans("kotoba::button.view") }}
					</a>
					<a href="{{ URL::to(\'/admin/contents/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
						<span class="glyphicon glyphicon-pencil"></span>  {{ trans("kotoba::button.edit") }}
					</a>
				'
				)

			->make(true);
	}


}
