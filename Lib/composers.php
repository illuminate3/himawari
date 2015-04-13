<?php
namespace App\Modules\Himawari\Lib;

use App\Modules\Himawari\Http\Domain\Models\Page;
//use App\Modules\Himawari\Lib\helpers;

use View;

View::composer('layouts.master', function ($view)
{
	if (!isset($view->title)) $view->title = 'Nested Set App';
});

View::composer(['layouts.content', 'layouts.backend'], function ($view)
{
	if (!isset($view->content)) $view->content = '';
});

View::composer('home.page', function ($view)
{
	$page = $view->page;

	$view->contents = make_nav_tree($page->getContents(), $page->getKey());
	$view->next = $page->getNext();
	$view->prev = $page->getPrev();
});


// View::composer(['_partials.left_side'], function ($view)
// //View::composer(['layouts._partials.left_side'], function ($view)
// {
// //$page = Page::with('contents')->whereSlug('/')->first();
// if ( $page != null ) {
// 	$contentTree = Page::where('parent_id', '!=', 'NULL')
// 		->get([ 'id', 'slug', 'title', '_lft', 'parent_id' ])
// 		->toTree();
// 	$view->menu2 = make_nav_tree($contentTree, $page->getKey());
// }
// //dd($menu2);
// });
