<?php

namespace App\Modules\Himawari\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HimawariDatabaseSeeder
 *
 * @package App\Modules\Himawari\Database\Seeds
 */
class HimawariDatabaseSeeder extends Seeder
{


	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('App\Modules\Himawari\Database\Seeds\ModulePermissionsSeeder');
		$this->call('App\Modules\Himawari\Database\Seeds\ModuleLinksSeeder');

		$this->call('App\Modules\Himawari\Database\Seeds\PrintStatusesSeeder');

	}


}
