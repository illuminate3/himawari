<?php

namespace App\Modules\Himawari\Database\Seeds;

use Illuminate\Database\Seeder;
Use DB, Eloquent, Model, Schema;


class PrintStatusesSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
//		DB::table('print_statuses')->truncate();

/*
		$seeds = array(
			array(
				'name'					=> 'Draft',
				'description'			=> 'Page is a draft'
			),
			array(
				'name'					=> 'Publish',
				'description'			=> 'Page has been Published'
			),
			array(
				'name'					=> 'Unpublish',
				'description'			=> 'Page has been unpublished'
			),
			array(
				'name'					=> 'Archieve',
				'description'			=> 'Page has been archieved'
			)
		);
*/


		$print_statuses = array(
		[
			'id'					=> 1
		],
		[
			'id'					=> 2
		],
		[
			'id'					=> 3
		],
		[
			'id'					=> 4
		]
		);
		$print_status_translations = array(
		[
			'name'					=> 'Draft',
			'description'			=> 'Page is a draft',
			'print_status_id'		=> 1,
			'locale_id'				=> 1
		],
		[
			'name'					=> 'Draft',
			'description'			=> 'Page is a draft',
			'print_status_id'		=> 1,
			'locale_id'				=> 2
		],
		[
			'name'					=> 'Publish',
			'description'			=> 'Page is a draft',
			'print_status_id'		=> 2,
			'locale_id'				=> 1
		],
		[
			'name'					=> 'Publish',
			'description'			=> 'Page has been Published',
			'print_status_id'		=> 2,
			'locale_id'				=> 2
		],
		[
			'name'					=> 'Unpublish',
			'description'			=> 'Page is a draft',
			'print_status_id'		=> 3,
			'locale_id'				=> 1
		],
		[
			'name'					=> 'Unpublish',
			'description'			=> 'Page has been unpublished',
			'print_status_id'		=> 3,
			'locale_id'				=> 2
		],
		[
			'name'					=> 'Archieve',
			'description'			=> 'Page has been archieved',
			'print_status_id'		=> 4,
			'locale_id'				=> 1
		],
		[
			'name'					=> 'Archieve',
			'description'			=> 'Page has been archieved',
			'print_status_id'		=> 4,
			'locale_id'				=> 2
		]
		);

		// Uncomment the below to run the seeder
//		DB::table('print_statuses')->insert($seeds);


// Create Menus
		DB::table('print_statuses')->delete();
			$statement = "ALTER TABLE print_statuses AUTO_INCREMENT = 1;";
			DB::unprepared($statement);
		DB::table('print_statuses')->insert( $print_statuses );

// Create Menu Translations
		DB::table('print_status_translations')->delete();
			$statement = "ALTER TABLE print_status_translations AUTO_INCREMENT = 1;";
			DB::unprepared($statement);
		DB::table('print_status_translations')->insert( $print_status_translations );


	} // run

}
