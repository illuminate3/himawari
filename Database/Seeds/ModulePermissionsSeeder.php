<?php

namespace App\Modules\Himawari\Database\Seeds;

use Illuminate\Database\Seeder;
Use DB;
use Schema;

class ModulePermissionsSeeder extends Seeder
{


	public function run()
	{

// Permissions -------------------------------------------------------------
		$permissions = array(
			[
				'name'				=> 'Manage Himawari CMS',
				'slug'				=> 'manage_himawari',
				'description'		=> 'Give permission to user to manage CMS'
			],
		 );

		if (Schema::hasTable('permissions'))
		{
			DB::table('permissions')->insert( $permissions );
		}

	} // run


}
