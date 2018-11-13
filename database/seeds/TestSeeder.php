<?php

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

            $this->call(UserTableSeeder::class);
            $this->call(CategoryTableSeeder::class);
            $this->call(TagsTableSeeder::class);
            $this->call(PostsTableSeeder::class);
    }
}
