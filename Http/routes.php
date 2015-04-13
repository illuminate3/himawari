<?php

/*
|--------------------------------------------------------------------------
| Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for the module.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('welcome/himawari', array(
	'uses'=>'HimawariController@welcome'
	));

// Controllers

// API DATA
// 	Route::get('api/sites', array(
// 	//	'as'=>'api.sites',
// 		'uses'=>'SitesController@data'
// 		));


//Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
Route::group(['prefix' => 'admin'], function() {

	Route::pattern('id', '[0-9]+');

// Controllers
	Route::resource('contents', 'ContentsController');

// Routes
	Route::delete('contents/{id}', array(
		'as'=>'contents.destroy',
		'uses'=>'ContentsController@destroy'
		));
// 	Route::delete('sites/{id}', array(
// 	//	'as'=>'sites.destroy',
// 		'uses'=>'SitesController@destroy'
// 		));

// API DATA
// 	Route::get('api/contents', array(
// 	//	'as'=>'api.contents',
// 		'uses'=>'ContentsController@data'
// 		));

});

// Route::get('/', 'PageController@show');
// Route::get('/', array(
// 	'as' => 'home',
// 	'uses' => 'PageController@show'
// 	));


Route::resource('pages', 'PagesController', array('except' => array('show')));

Route::group(array('prefix' => 'pages'), function () {

	Route::post("{id}/up", array(
		'as' => "pages.up",
		'uses' => "PagesController@up",
	));
	Route::post("{id}/down", array(
		'as' => "pages.down",
		'uses' => "PagesController@down",
	));


	Route::get('export', array(
		'as' => 'pages.export',
		'uses' => 'PagesController@export',
	));

	Route::get('{id}/confirm', array(
		'as' => 'pages.confirm',
		'uses' => 'PagesController@confirm',
	));

});


// The slug route should be registered last since it will capture any slug-like
// route
Route::get('{slug}', array('as' => 'page', 'uses' => 'PageController@show'))
	->where('slug', App\Modules\Himawari\Http\Domain\Models\Page::$slugPattern);


/*
//Route::when('assets/*', 'AssetsController');
*/
