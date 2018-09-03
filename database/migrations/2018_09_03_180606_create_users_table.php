<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('user_id');
			$table->string('username', 500);
			$table->string('password', 100);
			$table->string('first_name', 100)->nullable()->default('');
			$table->string('last_name', 100)->nullable()->default('');
			$table->text('dob', 65535)->nullable();
			$table->text('email', 65535);
			$table->text('function', 65535)->nullable();
			$table->string('img_path', 150)->nullable()->default('');
			$table->integer('album_id')->nullable();
			$table->string('remember_token', 100)->nullable()->default('');
			$table->timestamps();
			$table->boolean('trashed')->default(0);
			$table->boolean('approved')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
