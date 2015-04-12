<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageContentTable extends Migration
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
		Schema::create($this->prefix . 'page_content', function(Blueprint $table) {

			$table->engine = 'InnoDB';
			$table->increments('id');

			$table->integer('page_id')->unsigned()->index();
			$table->integer('content_id')->unsigned()->index();

			$table->foreign('page_id')->references('id')->on($this->prefix.'pages')->onDelete('cascade');
			$table->foreign('content_id')->references('id')->on($this->prefix.'contents')->onDelete('cascade');


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
		Schema::drop($this->prefix . 'page_content');
	}

}
