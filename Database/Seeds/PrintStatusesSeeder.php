<?php
namespace App\Modules\Himawari\Database\Seeds;

use Illuminate\Database\Seeder;
Use DB, Eloquent, Model, Schema;

class PrintStatusesSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('print_statuses')->truncate();

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

		// Uncomment the below to run the seeder
		DB::table('print_statuses')->insert($seeds);
	}

}
