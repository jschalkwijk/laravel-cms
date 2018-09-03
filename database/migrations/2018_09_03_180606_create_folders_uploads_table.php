<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFoldersUploadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('folders_uploads', function(Blueprint $table)
		{
			$table->integer('folder_id')->unsigned()->index('folder_id');
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
		Schema::drop('folders_uploads');
	}

}
