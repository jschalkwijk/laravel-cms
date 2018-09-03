<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function(Blueprint $table)
		{
			$table->integer('category_id', true);
			$table->string('title', 150);
			$table->string('description', 160);
			$table->string('content', 5000);
			$table->string('keywords', 3000);
			$table->string('type', 15);
			$table->boolean('approved')->default(0);
			$table->boolean('trashed')->default(0);
			$table->integer('parent_id')->nullable()->default(0);
			$table->integer('folder_id');
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
		Schema::drop('categories');
	}

}
