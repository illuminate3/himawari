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
			$table->increments('id');

			$table->integer('page_id')->nullable();
			$table->string('make')->nullable();
			$table->string('model')->nullable();
			$table->string('model_number')->nullable();
			$table->text('description')->nullable();
			$table->string('image')->nullable();

/*
			$table->integer('asset_id');
			$table->integer('site_id');
			$table->string('asset_tag')->unique()->index();
			$table->string('serial')->unique()->index();
			$table->string('po')->index();
			$table->string('custodian');
			$table->text('note')->nullable();
*/


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
