<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGalleriesUploadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('galleries_uploads', function(Blueprint $table)
		{
			$table->foreign('gallery_id', 'galleries_uploads_ibfk_1')->references('gallery_id')->on('galleries')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('upload_id', 'galleries_uploads_ibfk_2')->references('upload_id')->on('uploads')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('galleries_uploads', function(Blueprint $table)
		{
			$table->dropForeign('galleries_uploads_ibfk_1');
			$table->dropForeign('galleries_uploads_ibfk_2');
		});
	}

}
