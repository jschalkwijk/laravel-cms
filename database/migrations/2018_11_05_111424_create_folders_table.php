<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFoldersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('folders', function(Blueprint $table)
		{
			$table->increments('folder_id');
			$table->string('name', 60);
			$table->string('description', 140)->nullable()->default('');
			$table->integer('parent_id')->unsigned()->default(0)->index('parent_id');
			$table->string('path', 1000)->nullable();
			$table->string('size', 200)->nullable();
			$table->integer('user_id');
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
		Schema::drop('folders');
	}

}
