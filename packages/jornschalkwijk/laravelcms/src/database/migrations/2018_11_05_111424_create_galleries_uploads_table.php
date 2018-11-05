<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGalleriesUploadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('galleries_uploads', function(Blueprint $table)
		{
			$table->integer('gallery_id')->unsigned()->index('gallery_id');
			$table->integer('upload_id')->unsigned()->index('upload_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('galleries_uploads');
	}

}
