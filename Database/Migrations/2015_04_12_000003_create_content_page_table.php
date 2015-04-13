<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContentPageTable extends Migration
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
		Schema::create($this->prefix . 'content_page', function(Blueprint $table) {

			$table->engine = 'InnoDB';
			$table->increments('id');

			$table->integer('content_id')->unsigned()->index();
			$table->integer('page_id')->unsigned()->index();

			$table->foreign('content_id')->references('id')->on($this->prefix.'contents')->onDelete('cascade');
			$table->foreign('page_id')->references('id')->on($this->prefix.'pages')->onDelete('cascade');


// 			$table->softDeletes();
// 			$table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop($this->prefix . 'content_page');
	}

}
