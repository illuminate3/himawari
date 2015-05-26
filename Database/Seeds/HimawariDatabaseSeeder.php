<?php
namespace App\Modules\Himawari\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class HimawariDatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('App\Modules\Himawari\Database\Seeds\ModuleSeeder');
		$this->call('App\Modules\Himawari\Database\Seeds\PrintStatusesSeeder');
// 		$this->call('App\Modules\Himawari\Database\Seeds\PagesSeeder');
// 		$this->call('App\Modules\Himawari\Database\Seeds\ContentsSeeder');

	}

}
