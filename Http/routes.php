<?php

/*
|--------------------------------------------------------------------------
| Origami
|--------------------------------------------------------------------------
*/

Route::pattern('page', '[0-9a-z]+');

// Resources
// Controllers

Route::group(['prefix' => 'himawari'], function() {
	Route::get('welcome', [
		'uses'=>'HimawariController@welcome'
	]);
});

// API DATA

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/


//Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
Route::group(['prefix' => 'admin'], function() {

// Controllers

	Route::get('contents/repair', array(
		'uses'=>'ContentsController@repairTree'
		));

// Resources

	Route::resource('contents', 'ContentsController');
	Route::resource('print_statuses', 'PrintStatusesController');


});

Route::get('{page}', 'FrontendController@get_page')->where('page', '.*');
