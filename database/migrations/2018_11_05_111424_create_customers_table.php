<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers', function(Blueprint $table)
		{
			$table->integer('customer_id', true);
			$table->string('name');
			$table->string('email');
			$table->string('phone', 15);
			$table->string('address1', 200);
			$table->string('address2');
			$table->string('city', 200);
			$table->string('postal', 12);
			$table->integer('country_id')->default(0);
			$table->integer('user_id')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customers');
	}

}
