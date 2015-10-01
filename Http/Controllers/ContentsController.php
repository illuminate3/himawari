<?php

namespace App\Modules\Himawari\Http\Controllers;

use App\Modules\Core\Http\Repositories\LocaleRepository;

use App\Modules\Himawari\Http\Models\Content;
use App\Modules\Himawari\Http\Repositories\ContentRepository;

use Illuminate\Http\Request;
use App\Modules\Himawari\Http\Requests\DeleteRequest;
use App\Modules\Himawari\Http\Requests\ContentCreateRequest;
use App\Modules\Himawari\Http\Requests\ContentUpdateRequest;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;

use Cache;
use Flash;
use Lang;
use Route;
use Session;
use Theme;


class ContentsController extends HimawariController {

	/**
	 * Content Repository
	 *
	 * @var Content
	 */
	protected $content;

	public function __construct(
			LocaleRepository $locale_repo,
			Content $content,
			ContentRepository $content_repo
		)
	{
		$this->locale_repo = $locale_repo;
		$this->content = $content;
		$this->content_repo = $content_repo;
// middleware
		parent::__construct();
// middleware
// 		$this->middleware('auth');
// 		$this->middleware('admin');
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$lang = Session::get('locale');
		$locale_id = $this->locale_repo->getLocaleID($lang);
//dd($locale_id);

		$contents = $this->content_repo->all();
//		$contents = Content::getNestedList('title', 'id', '>> ');
//dd($contents);

		$list = Content::all();
		$list = $list->toHierarchy();
//dd($list);


		return Theme::View('modules.himawari.contents.index',
			compact(
				'contents',
				'list',
				'lang',
				'locale_id'
			));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return Theme::View('modules.himawari.contents.create',  $this->content_repo->create());
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
//dd($request);

		$this->content->store($request->all());
		Cache::flush();

		Flash::success( trans('kotoba::cms.success.content_create') );
		return redirect('admin/contents');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
// 		$content = $this->content->findOrFail($id);
//
// 		return View::make('HR::contents.show', compact('content'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$content = $this->content->with('images', 'documents')->find($id);
//dd($content);

		$lang = Session::get('locale');
		$locale_id = $this->locale_repo->getLocaleID($lang);
//dd($locale_id);

//		$pagelist = $this->getParents( $exceptId = $this->id, $locales );

// 		$pagelist = $this->getParents($locale_id, $id);
// 		$pagelist = array('' => trans('kotoba::cms.no_parent')) + $pagelist;
//dd($pagelist);
		$all_pagelist = $this->content_repo->getParents($locale_id, null);
		$pagelist = array('' => trans('kotoba::cms.no_parent'));
		$pagelist = new Collection($pagelist);
		$pagelist = $pagelist->merge($all_pagelist);

		$users = $this->content_repo->getUsers();
		$users = array('' => trans('kotoba::general.command.select_a') . '&nbsp;' . Lang::choice('kotoba::account.user', 1) ) + $users;
//dd($users);
		$print_statuses = $this->content_repo->getPrintStatuses($locale_id);
		$print_statuses = array('' => trans('kotoba::general.command.select_a') . '&nbsp;' . Lang::choice('kotoba::cms.print_status', 1) ) + $print_statuses;

		$get_images = $this->content_repo->getImages();
//dd($images);

		$get_documents = $this->content_repo->getDocuments();

//		$user_id = Auth::user()->id;

		$modal_title = trans('kotoba::general.command.delete');
		$modal_body = trans('kotoba::general.ask.delete');
		$modal_route = 'admin.contents.destroy';
		$modal_id = $id;
//		$model = '$content';
		$model = 'content';
//dd($model);

		return Theme::View('modules.himawari.contents.edit',
			compact(
				'content',
				'get_documents',
				'get_images',
				'lang',
//				'locales',
				'pagelist',
				'print_statuses',
				'users',
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
//dd($request);

		$this->content_repo->update($request->all(), $id);
		Cache::flush();

		if ( Input::get('previous_document_id') == null ) {
			$document_id = Input::get('document_id');
			if ( $document_id != null ) {
				$this->content_repo->detachDocument($id, $document_id);
				$this->content_repo->attachDocument($id, $document_id);
			}
		}

		if ( Input::get('previous_image_id') == null ) {
			$image_id = Input::get('image_id');
			if ( $image_id != null ) {
				$this->content_repo->detachImage($id, $image_id);
				$this->content_repo->attachImage($id, $image_id);
			}
		}

		Flash::success( trans('kotoba::cms.success.content_update') );
		return redirect('admin/contents');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
// 	public function destroy($id)
// 	{
// //dd($id);
// 		Content::find($id)->delete();
//
// 		Flash::success( trans('kotoba::cms.success.content_delete') );
// 		return redirect('admin/contents');
// 	}
	public function destroy($id)
	{
		$node = Content::find($id);
		$parent = $node->parent()->get();
		$children = $node->children()->get();
//dd($parent);

		foreach($node->getImmediateDescendants() as $descendant) {
//			print_r($descendant->title . '<br>');
			$descendant->makeSiblingOf($node);
		}

		Content::find($id)->delete();

		if ( Content::isValidNestedSet() == false ) {
			Content::rebuild();
		}

		Flash::success( trans('kotoba::cms.success.category_delete') );
		return redirect('admin/contents');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function repairTree()
	{

		if ( Content::isValidNestedSet() == false ) {
			Content::rebuild();
			Flash::success( trans('kotoba::cms.success.repaired') );
			return redirect('admin/contents');
		}

			Flash::info( trans('kotoba::cms.error.repair') );
			return redirect('admin/contents');

	}


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
		$query = Content::select('id', 'name', 'description', 'updated_at');
//dd($query);

		return Datatables::of($query)
//			->remove_column('id')

			->addColumn(
				'actions',
				'
					<a href="{{ URL::to(\'admin/contents/\' . $id . \'/edit\' ) }}" class="btn btn-success btn-sm" >
						<span class="glyphicon glyphicon-pencil"></span>  {{ trans("kotoba::button.edit") }}
					</a>
				'
				)

			->make(true);
	}

}
