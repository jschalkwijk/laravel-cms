<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToRolesPermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('roles_permissions', function(Blueprint $table)
		{
			$table->foreign('role_id', 'roles_permissions_ibfk_1')->references('role_id')->on('roles')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('permission_id', 'roles_permissions_ibfk_2')->references('permission_id')->on('permissions')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('roles_permissions', function(Blueprint $table)
		{
			$table->dropForeign('roles_permissions_ibfk_1');
			$table->dropForeign('roles_permissions_ibfk_2');
		});
	}

}
