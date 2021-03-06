<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContentsTable extends Migration
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
		Schema::create($this->prefix . 'contents', function(Blueprint $table) {

			$table->engine = 'InnoDB';
			$table->increments('id')->unsigned();

			$table->integer('user_id')->unsigned();
			$table->integer('parent_id')->nullable();
			$table->integer('lft')->nullable();
			$table->integer('rgt')->nullable();
			$table->integer('depth')->nullable();

// 			$table->string('title', 255)->nullable();
// 			$table->string('summary',512)->nullable();
// 			$table->text('content')->nullable();
			$table->string('slug')->nullable();

//			$table->integer('image_id')->nullable();
			$table->string('class', 50)->nullable();
//			$table->text('link', 255)->nullable();

			$table->tinyInteger('print_status_id')->default(0);
// 			$table->tinyInteger('menu_id')->default(1);
			$table->tinyInteger('is_timed')->default(0);
			$table->tinyInteger('is_private')->default(0);
			$table->tinyInteger('is_navigation')->default(0);
			$table->date('publish_start')->nullable();
			$table->date('publish_end')->nullable();

			$table->integer('order')->nullable();

			$table->foreign('user_id')->references('id')->on('users');

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
		Schema::drop($this->prefix . 'contents');
	}

}
