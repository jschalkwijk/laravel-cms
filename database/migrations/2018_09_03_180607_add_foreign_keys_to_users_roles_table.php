<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUsersRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_roles', function(Blueprint $table)
		{
			$table->foreign('user_id', 'users_roles_ibfk_1')->references('user_id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('role_id', 'users_roles_ibfk_2')->references('role_id')->on('roles')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_roles', function(Blueprint $table)
		{
			$table->dropForeign('users_roles_ibfk_1');
			$table->dropForeign('users_roles_ibfk_2');
		});
	}

}
