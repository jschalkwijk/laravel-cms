<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contacts', function(Blueprint $table)
		{
			$table->integer('contact_id', true);
			$table->binary('first_name', 500);
			$table->binary('last_name', 500);
			$table->binary('phone_1', 500);
			$table->binary('phone_2', 500);
			$table->binary('email_1', 500);
			$table->binary('email_2', 500);
			$table->binary('dob', 500);
			$table->binary('street', 500);
			$table->binary('street_num', 500);
			$table->binary('street_num_add', 500);
			$table->binary('zip', 500);
			$table->binary('notes', 500);
			$table->boolean('trashed')->default(0);
			$table->boolean('approved')->default(1);
			$table->binary('img_path', 500);
			$table->integer('user_id');
			$table->dateTime('date');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contacts');
	}

}
