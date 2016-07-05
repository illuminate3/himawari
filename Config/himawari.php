<?php

return [

//vendor:publish --provider="App\Modules\Himawari\Providers\HimawariServiceProvider" --tag="config"
//vendor:publish --provider="App\Modules\Himawari\Providers\HimawariServiceProvider" --tag="js"
//vendor:publish --provider="App\Modules\Himawari\Providers\HimawariServiceProvider" --tag="plugins"
//vendor:publish --provider="App\Modules\Himawari\Providers\HimawariServiceProvider" --tag="views"

/*
|--------------------------------------------------------------------------
| db settings
|--------------------------------------------------------------------------
*/
'himawari_db' => array(
	'prefix'					=> '',
),

'default_publish_status'		=> 1,

'auth_fail_redirect'			=> '/admin/dashboard',

'editor_one'					=> 829,
'editor_two'					=> 518,

'mailer' => [
	'from_email'				=> '',
	'from_name'					=> '',
	'group_slug'				=> 'cms-mailer-group',
	'template'					=> 'cms',
	'create_canned_slug'		=> 'content_created',
	'update_canned_slug'		=> 'content_update',
],


];
