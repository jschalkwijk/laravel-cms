<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(JornSchalkwijk\LaravelCMS\Models\User::class, 10)->create()->each(function ($user) {
            $user->roles()->attach(\JornSchalkwijk\LaravelCMS\Models\Role::all()->random()->role_id);
        });
    }
}
