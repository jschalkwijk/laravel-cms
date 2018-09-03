<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->integer('post_id', true);
			$table->string('title', 150)->default('');
			$table->string('description', 160)->nullable();
			$table->string('content', 5000);
			$table->string('keywords', 3000)->nullable();
			$table->boolean('approved')->default(0);
			$table->integer('category_id')->nullable();
			$table->boolean('trashed')->default(0);
			$table->integer('user_id');
			$table->dateTime('locked_till')->nullable();
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
		Schema::drop('posts');
	}

}
