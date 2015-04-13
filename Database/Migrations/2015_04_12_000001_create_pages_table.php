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

			NestedSet::columns($table);

//			$table->string('slug')->unique();
//			$table->string('title');
			$table->integer('user_id')->index()->unsigned();

			$table->tinyInteger('print_status_id')->default(0);
			$table->tinyInteger('is_published')->default(0);
			$table->tinyInteger('is_featured')->default(0);

//			$table->tinyInteger('menu_id')->default(1);

			$table->date('publish_start')->nullable();
			$table->date('publish_end')->nullable();


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
