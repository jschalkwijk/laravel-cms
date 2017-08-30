<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CMS\Models\Category::class, 20)->create()->each(function($category){
            $category->posts()->save(factory(CMs\Models\Post::class)->make());
        });
    }
}
