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
Route::controller('scans', 'ScansController');
Route::get('scans/index',
	[
		'as' => 'scans.index',
		'uses' => 'ScansController@index',
	]
);
Route::post('scans/asset',
	[
		'as' => 'scans.asset',
		'uses' => 'ScansController@postAsset',
	]
);
Route::get('scans/asset',
	[
		'as' => 'scans.asset',
		'uses' => 'ScansController@getAsset',
	]
);
Route::get('scans/room',
	[
		'as' => 'scans.room',
		'uses' => 'ScansController@getRoom',
	]
);
Route::post('scans/room',
	[
		'as' => 'scans.room',
		'uses' => 'ScansController@postRoom',
	]
);
Route::post('scans/user',
	[
		'as' => 'scans.user',
		'uses' => 'ScansController@postUser',
	]
);
Route::get('scans/user',
	[
		'as' => 'scans.user',
		'uses' => 'ScansController@getUser',
	]
);

// API DATA
// 	Route::get('api/sites', array(
// 	//	'as'=>'api.sites',
// 		'uses'=>'SitesController@data'
// 		));


//Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
Route::group(['prefix' => 'admin'], function() {

	Route::pattern('id', '[0-9]+');

// Controllers
	Route::resource('asset', 'AssetsController');
	Route::resource('asset_statuses', 'AssetStatusesController');
	Route::resource('contents', 'ContentsController');
	Route::resource('tech_statuses', 'TechStatusesController');

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
	Route::get('api/assets', array(
//		'as'=>'api.assets',
		'uses'=>'AssetsController@data'
		));
	Route::get('api/asset_statuses', array(
//		'as'=>'api.asset_statuses',
		'uses'=>'AssetStatusesController@data'
		));
	Route::get('api/contents', array(
	//	'as'=>'api.contents',
		'uses'=>'ContentsController@data'
		));
	Route::get('api/tech_statuses', array(
//		'as'=>'api.tech_statuses',
		'uses'=>'TechStatusesController@data'
		));

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
