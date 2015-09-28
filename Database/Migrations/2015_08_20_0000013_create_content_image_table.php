<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


class CreateContentImageTable extends Migration
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

		Schema::create($this->prefix . 'content_image', function(Blueprint $table) {

			$table->engine = 'InnoDB';

			$table->integer('content_id')->unsigned()->index();
			$table->integer('image_id')->unsigned()->index();

			$table->foreign('content_id')->references('id')->on($this->prefix.'contents')->onDelete('cascade');
			$table->foreign('image_id')->references('id')->on($this->prefix.'images')->onDelete('cascade');

		});

	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop($this->prefix . 'content_image');
	}


}
