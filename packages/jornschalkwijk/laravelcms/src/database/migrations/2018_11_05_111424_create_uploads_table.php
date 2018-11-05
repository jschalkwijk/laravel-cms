<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUploadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('uploads', function(Blueprint $table)
		{
			$table->increments('upload_id');
			$table->string('name', 50);
			$table->string('file_name', 100);
			$table->string('thumb_name', 100)->nullable()->default('');
			$table->string('type', 50);
			$table->string('file_path', 5000)->nullable()->default('');
			$table->string('thumb_path', 5000)->nullable()->default('');
			$table->integer('folder_id');
			$table->integer('user_id');
			$table->string('size', 100)->nullable();
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
		Schema::drop('uploads');
	}

}
