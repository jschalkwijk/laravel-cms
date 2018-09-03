<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function(Blueprint $table)
		{
			$table->integer('comment_id', true);
			$table->text('content')->nullable();
			$table->integer('post_id')->nullable()->index('post_id');
			$table->integer('user_id');
			$table->timestamp('date')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->boolean('approved')->default(1);
			$table->boolean('trashed')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('comments');
	}

}
