<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function(Blueprint $table)
		{
			$table->integer('page_id', true);
			$table->string('slug', 160)->default('');
			$table->string('title', 160)->default('');
			$table->string('description', 160);
			$table->string('content', 10000);
			$table->string('template', 100)->nullable();
			$table->integer('parent_id')->default(0);
			$table->boolean('approved')->default(0);
			$table->boolean('trashed')->default(0);
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
		Schema::drop('pages');
	}

}
