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
/*

            $table->unique(array('page_id', 'locale'));
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');

        });
*/

		Schema::create($this->prefix . 'contents', function(Blueprint $table) {

			$table->engine = 'InnoDB';
			$table->increments('id');

			$table->integer('page_id')->index()->unique()->unsigned();
			$table->string('locale')->index()->nullable();

			$table->string('slug')->unique()->nullable();

			$table->string('title')->unique()->nullable();
			$table->string('summary')->nullable();
			$table->text('body')->nullable();

			$table->string('meta_title')->nullable();
			$table->string('meta_keywords')->nullable();
			$table->string('meta_description')->nullable();

			$table->string('uri')->unique()->nullable();


/*
			$table->string('image')->nullable();
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
