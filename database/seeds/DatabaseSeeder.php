<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(CMS\Models\Category::class, 20)->create()->each(function($category){
            $category->posts()->save(factory(CMS\Models\Post::class)->make());
        });

}
}
