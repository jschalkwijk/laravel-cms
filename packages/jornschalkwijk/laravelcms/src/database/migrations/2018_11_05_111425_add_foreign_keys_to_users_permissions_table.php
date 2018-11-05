<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUsersPermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_permissions', function(Blueprint $table)
		{
			$table->foreign('permission_id', 'users_permissions_ibfk_1')->references('permission_id')->on('permissions')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('user_id', 'users_permissions_ibfk_2')->references('user_id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_permissions', function(Blueprint $table)
		{
			$table->dropForeign('users_permissions_ibfk_1');
			$table->dropForeign('users_permissions_ibfk_2');
		});
	}

}
