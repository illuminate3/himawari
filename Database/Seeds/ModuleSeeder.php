<?php

namespace App\Modules\Himawari\Database\Seeds;

use Illuminate\Database\Seeder;
Use DB, Eloquent, Model, Schema;


class ModuleSeeder extends Seeder {

	public function run()
	{

// Module Information
// 		$module = array(
// 			'name'					=> 'Himawari',
// 			'slug'					=> 'himawari',
// 			'version'				=> '1.0',
// 			'description'			=> 'CMS for Rakko',
// 			'enabled'				=> 1,
// 			'order'					=> 12
// 		);

// Insert Module Information
// 		if (Schema::hasTable('modules'))
// 		{
//
// 			DB::table('modules')->insert( $module );
//
// 		}

// Permission Information
		$permissions = array(
			[
				'name'				=> 'Manage Himawari CMS',
				'slug'				=> 'manage_himawari',
				'description'		=> 'Give permission to user to manage CMS'
			],
		 );

// Insert Permissions
		DB::table('permissions')->insert( $permissions );


	} // run


}
