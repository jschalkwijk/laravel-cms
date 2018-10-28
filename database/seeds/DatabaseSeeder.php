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
//        factory(CMS\Models\Category::class, 40)->create()->each(function(git category){
//            $category->posts()->save(factory(CMS\Models\Post::class)->make());
//        });
            factory(JornSchalkwijk\LaravelCMS\Models\User::class, 10)->create();
            factory(JornSchalkwijk\LaravelCMS\Models\Category::class, 20)->create();
            factory(JornSchalkwijk\LaravelCMS\Models\Category::class, 20)->create();

            factory(JornSchalkwijk\LaravelCMS\Models\Post::class, 20)->create()->each(
                function ($post) {
                    $post->tags()->save(
                        factory(JornSchalkwijk\LaravelCMS\Models\Tag::class)->make()
                    );
                });
            factory(JornSchalkwijk\LaravelCMS\Models\Product::class, 20)->create()->each(
                function ($product) {
                    $product->tags()->save(
                        factory(JornSchalkwijk\LaravelCMS\Models\Tag::class)->make()
                    );
                });

//            factory(CMS\Models\Product::class, 20)->create();
//            foreach ((range(1, 20)) as $index) {
//                DB::table('taggables')->insert(
//                    [
//                        'tag_id'        => rand(1, 20),
//                        'taggable_id'   => rand(1, 20),
//                        'taggable_type' => rand(0, 1) == 1 ? 'App\Post' : 'App\Video'
//                    ]
//                );
//            }


        }
    }