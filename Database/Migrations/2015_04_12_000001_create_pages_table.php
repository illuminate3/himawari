<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration
{

	public function __construct()
	{
		// Get the prefix
		$this->prefix = Config::get('himawari.himawari_db.prefix', '');
	}

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->prefix . 'pages', function(Blueprint $table) {

			$table->engine = 'InnoDB';
			$table->increments('id');


			$table->string('slug')->unique();
			$table->string('title');

			NestedSet::columns($table);


			$table->softDeletes();
			$table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop($this->prefix . 'pages');
	}

}
