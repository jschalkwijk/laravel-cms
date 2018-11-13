<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use JornSchalkwijk\LaravelCMS\Models\Tag;
USE JornSchalkwijk\LaravelCMS\Models\Category;
use JornSchalkwijk\LaravelCMS\Models\User;
class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::all()->isEmpty()){
            $this->call(UserTableSeeder::class);
        }
        if(Tag::all()->isEmpty()) {
            $this->call(TagsTableSeeder::class);
        }
        if(Category::all()->isEmpty()) {
            $this->call(CategoryTableSeeder::class);
        }

        factory(JornSchalkwijk\LaravelCMS\Models\Post::class, 20)->create()->each(
            function ($post) {
                $post->tags()->attach(
                    JornSchalkwijk\LaravelCMS\Models\Tag::where('type','post')->get()->random()->tag_id
                );
            }
        );
    }
}
