<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRepliesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('replies', function(Blueprint $table)
		{
			$table->increments('reply_id');
			$table->text('content')->nullable();
			$table->integer('comment_id')->nullable()->index('comment_id');
			$table->integer('user_id');
			$table->timestamp('date')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->boolean('approved')->default(1);
			$table->boolean('trashed')->default(0);
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
		Schema::drop('replies');
	}

}
