<?php

namespace App\Modules\Himawari\Http\Controllers;

use App\Modules\Core\Http\Repositories\LocaleRepository;

use App\Modules\Himawari\Http\Models\Content;
use App\Modules\Himawari\Http\Repositories\ContentRepository;

use Illuminate\Http\Request;
use App\Modules\Himawari\Http\Requests\DeleteRequest;
use App\Http\Requests\PageCreateRequest;
use App\Http\Requests\PageUpdateRequest;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;

use Carbon\Carbon;
use Config;
use Flash;
use Hashids\Hashids;
use Meta;
use Session;
use Route;
use Theme;

class FrontendController extends HimawariController {

	public function __construct(
			LocaleRepository $locale_repo,
			Content $content,
			ContentRepository $content_repo
		)
	{
//dd('__construct');
		$this->locale_repo = $locale_repo;
		$this->content = $content;
		$this->content_repo = $content_repo;

		$lang = Session::get('locale');
		$locale_id = $this->locale_repo->getLocaleID($lang);
//dd($locale_id);

//		$this->hashIds = new Hashids( Config::get('app.key'), 8, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' );


		$this->page = Route::current()->parameter('page');
//dd($this->page);
/*
		$slugs = explode('/', $this->page);
//dd($slugs);
		$lastSlug = Route::current()->getName() == 'search' ? 'search' : $slugs[count($slugs)-1];
//dd($lastSlug);
*/

		$lastSlug = $this->page;
//dd($lastSlug);

//		$this->currentPage = Page::getPage( $slug = $lastSlug );
//		$this->currentPage = Content::getPage( $slug = $lastSlug );
//		$this->currentPage = $this->content_repo->getPage($locale_id, $slug = $lastSlug);
//		$this->currentPage = new \Illuminate\Support\Collection($this->currentPage);

		$page_ID = $this->content_repo->getPageID($lastSlug, $locale_id);
//dd($page_ID);
		$this->currentPage = $this->content_repo->getContent($page_ID);
//		$this->currentPage = Content::IsPublished()->SiteID()->with('images', 'documents', 'sites')->find($article_ID);
//dd($this->currentPage);

//dd('here');
//		$this->roots = Page::getRoots();
//		$this->roots = Content::getRoots();
//		$this->roots = $this->content_repo->getRoots($locale_id);
//		$this->roots = Content::getRoots($locale_id);
//dd($this->roots);

// 		$this->postsOrderBy = ['id', 'desc'];
// 		$this->postsOrderByOrder = ['order', 'asc'];
// 		$this->postItemsNum = 10;
// 		$this->postItemsPerPage = 2;
		// $this->latestNewsPosts = Post::getLatestNewsPosts($this->postItemsNum, $this->postsOrderBy);
// 		$this->contact = ["Demo NiftyCMS", "demo@niftycms.com"];

	}

	public function get_page()
	{

//dd($this->currentPage);
		if ( $this->currentPage ) {

			$page = $this->currentPage;
//dd($page);

/*
	0 => "meta_description"
	1 => "meta_keywords"
	2 => "meta_title"
	3 => "content"
	4 => "slug"
	5 => "summary"
	6 => "title"
*/
			Meta::setKeywords($page->meta_keywords);
			Meta::setDescription($page->meta_description);

			$lang = Session::get('locale');
			$js_lang = array(
	//			'CLOSE' => trans('kotoba::button.close'),
	//			'TITLE' => $document->document_file_name
				'CLOSE' => "Close",
				'TITLE' => "View Document"
			);

			$modal_title = trans('kotoba::general.command.delete');
			$modal_body = trans('kotoba::general.ask.delete');
			$modal_route = 'admin.documents.destroy';
			$modal_id = $page->id;
			$model = '$document';

			return Theme::View('modules.himawari.frontend.index',
				compact(
					'page',
					'js_lang',
					'modal_title',
					'modal_body',
					'modal_route',
					'modal_id',
					'model'
				));
		} else {
			App::abort(404);
		}

	}

	public function index()
	{
dd('index');
		if ( $homePage = Page::getPage( $slug = 'home-page' ) ) {
			$mainMenu = NiftyMenus::getMainMenu( $homePage );
			// $posts = Post::getFrontendPosts($category = 'Home Featured', $this->postsOrderBy);
//			return View::make('frontends.index', ['page' => $homePage, /*'posts' => $posts,*/ 'mainMenu' => $mainMenu]);

			$page = $homePage;
			$mainMenu = $mainMenu;

			return View('nifty.frontends.index', compact(
				'mainMenu',
				'page'
				));
		}
		else
			App::abort(404);
	}

	public function contact_us()
	{
dd('contact_us');
		if ( $contact_us = Page::getPage( $slug = 'contact-us' ) ) {
			$mainMenu = NiftyMenus::getMainMenu( $contact_us );
			$root = $contact_us->getRoot();
			$secMenu = NiftyMenus::getSecMenu($root, $contact_us);
			return View::make('frontends.contact-us', ['page' => $contact_us, 'active' => '', 'mainMenu' => $mainMenu, 'secMenu' => $secMenu]);
		}
		else
			App::abort(404);
	}

	public function do_contact_us()
	{
dd('do_contact_us');
		$inputs = [];
		foreach(Input::all() as $key=>$input)
		{
			$inputs[$key] = Sanitiser::trimInput($input);
		}

		$rules = [
					'name' => 'required|max:255',
					'email' => 'required|email',
					'subject' => 'required',
					'message' => 'required'
				];

		$validation = MyValidations::validate($inputs, $rules);

		if($validation != NULL) {
			return Redirect::back()->withErrors($validation)->withInput();
		}

		else {
    		$data = [ 'name' => $inputs['name'], 'emailbody' => $inputs['message'] ];
    		$to_email = $this->contact[1];
    		$to_name = $this->contact[0];

			$issent =
			Mail::send('emails.contact-us', $data, function($message) use ($inputs, $to_email, $to_name)
			{
			    $message->from($inputs['email'], $inputs['name'])->to($to_email, $to_name)->subject('Website Contact Us: ' . $inputs['subject']);
			});

			if ($issent) {
				$feedback = ['success', 'Message successfully sent. We will be in touch soon'];
			}

			else {
				$feedback = ['failure', 'Your email was not sent. Kindly try again.'];
			}

			return Redirect::to('contact-us')->with($feedback[0], $feedback[1]);
		}
	}

	public function previewPage($hashedId)
	{
dd('previewPage');
		$id = $this->hashIds->decrypt($hashedId)[0];

		if ( $id ) {
			$previewPage = Page::getPreviewPage( $id );
			$mainMenu = NiftyMenus::getMainMenu( $previewPage );
			$root = $previewPage->getRoot();
			$secMenu = NiftyMenus::getSecMenu( $root, $previewPage );

			return View::make('frontends.page', ['page' => $previewPage, 'mainMenu' => $mainMenu, 'secMenu' => $secMenu]);
		}
		else
			App::abort(404);
	}

	public function get_blog()
	{
dd('get_blog');
		if ( $blog = Page::getPage( $slug = 'blog' ) ) {
			$mainMenu = NiftyMenus::getMainMenu( $blog );
			$root = $blog->getRoot();
			$secMenu = NiftyMenus::getSecMenu($root, $blog);

			$posts = Post::getFrontendPosts( $this->postsOrderBy, $this->postItemsNum, $this->postItemsPerPage );

			return View::make('frontends.blog', ['page' => $blog, 'posts' => $posts, 'links' => $posts->links('backend.pagination.nifty'), 'active' => '', 'mainMenu' => $mainMenu, 'secMenu' => $secMenu]);
		}
		else
			App::abort(404);
	}

	public function get_post()
	{
dd('get_post');
		$slugs = explode( '/', Route::current()->parameter('any') );
		$lastSlug = $slugs[count($slugs)-1];

		if ( $blog = Page::getPage( $slug = 'blog' ) ) {
			$mainMenu = NiftyMenus::getMainMenu( $blog );
			$root = $blog->getRoot();
			$secMenu = NiftyMenus::getSecMenu($root, $blog);

			$post = Post::getFrontendPost( $lastSlug );

			$posts = Post::getFrontendPosts( $this->postsOrderBy, $this->postItemsNum, $this->postItemsPerPage );

			return View::make('frontends.post', ['page' => $post, 'posts' => $posts, 'active' => '', 'mainMenu' => $mainMenu, 'secMenu' => $secMenu]);
		}
		else
			App::abort(404);
	}

	public function previewPost($hashedId)
	{
dd('previewPost');
		$id = $this->hashIds->decrypt($hashedId)[0];

		if ( $id ) {
			$blogPage = Page::getPage( $lug = 'blog' );
			$blogPost = Post::find($id);
			$mainMenu = NiftyMenus::getMainMenu( $blogPage );
			$root = $blogPage->getRoot();
			$secMenu = NiftyMenus::getSecMenu( $root, $blogPage );

			$posts = Post::getFrontendPosts( $this->postsOrderBy, $this->postItemsNum, $this->postItemsPerPage );

			return View::make('frontends.post', ['page' => $blogPost, 'posts' => $posts, 'mainMenu' => $mainMenu, 'secMenu' => $secMenu]);
		}
		else
			App::abort(404);
	}

	public function do_search()
	{
dd('do_search');
		$term = Sanitiser::trimInput( Input::get('term') );
		$results = Search::getSearchResults($term);

		$searchPage = Page::getPage( $slug = 'search' );
		$mainMenu = NiftyMenus::getMainMenu( $searchPage );
		$secMenu = '';

		return View::make('frontends.search', ['page' => $searchPage, 'term' => $term, 'results' => $results, 'mainMenu' => $mainMenu, 'secMenu' => $secMenu]);
	}

}
