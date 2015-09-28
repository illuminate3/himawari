<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


class CreateContentDocumentTable extends Migration
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

		Schema::create($this->prefix . 'content_document', function(Blueprint $table) {

			$table->engine = 'InnoDB';

			$table->integer('content_id')->unsigned()->index();
			$table->integer('document_id')->unsigned()->index();

			$table->foreign('content_id')->references('id')->on($this->prefix.'contents')->onDelete('cascade');
			$table->foreign('document_id')->references('id')->on($this->prefix.'documents')->onDelete('cascade');

		});

	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop($this->prefix . 'content_document');
	}


}
