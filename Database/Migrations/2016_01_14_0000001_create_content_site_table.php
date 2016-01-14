<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateContentSiteTable
 */
class CreateContentSiteTable extends Migration
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

		Schema::create($this->prefix . 'content_site', function(Blueprint $table) {

			$table->engine = 'InnoDB';

			$table->integer('content_id')->unsigned()->index();
			$table->integer('site_id')->unsigned()->index();
//			$table->integer('order')->unsigned()->nullable();

			$table->foreign('content_id')->references('id')->on($this->prefix.'contents')->onDelete('cascade');
			$table->foreign('site_id')->references('id')->on($this->prefix.'sites')->onDelete('cascade');

		});

	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop($this->prefix . 'content_site');
	}


}
