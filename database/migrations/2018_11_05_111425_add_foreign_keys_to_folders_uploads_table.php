<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToFoldersUploadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('folders_uploads', function(Blueprint $table)
		{
			$table->foreign('folder_id', 'folders_uploads_ibfk_1')->references('folder_id')->on('folders')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('upload_id', 'folders_uploads_ibfk_2')->references('upload_id')->on('uploads')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('folders_uploads', function(Blueprint $table)
		{
			$table->dropForeign('folders_uploads_ibfk_1');
			$table->dropForeign('folders_uploads_ibfk_2');
		});
	}

}
