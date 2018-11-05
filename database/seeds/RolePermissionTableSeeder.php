<?php

use Illuminate\Database\Seeder;
use JornSchalkwijk\LaravelCMS\Models\Role;
use JornSchalkwijk\LaravelCMS\Models\Permission;
class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::where('name','admin')->permissions->attach(Permission::all());

    }
}
