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

//            $this->call(FoldersTableSeeder::class);
//            $this->call(PermissionsTableSeeder::class);
//            $this->call(RolesTableSeeder::class);
//            $this->call(RolePermissionTableSeeder::class);
//            $this->call(TagsTableSeeder::class);

//            factory(JornSchalkwijk\LaravelCMS\Models\User::class, 10)->create()->each(function ($user) {
//                $user->roles()->attach(\JornSchalkwijk\LaravelCMS\Models\Role::all()->random()->role_id);
//            });
//            factory(JornSchalkwijk\LaravelCMS\Models\Category::class, 20)->create();
//
            factory(JornSchalkwijk\LaravelCMS\Models\Tag::class, 20)->create();

            factory(JornSchalkwijk\LaravelCMS\Models\Post::class, 20)->create()->each(
                function ($post) {
                    $post->tags()->attach(
                        JornSchalkwijk\LaravelCMS\Models\Tag::where('type','post')->get()->random()->tag_id
                    );
                });
//            factory(JornSchalkwijk\LaravelCMS\Models\Product::class, 20)->create()->each(
//                function ($product) {
//                    $product->tags()->save(
//                        factory(JornSchalkwijk\LaravelCMS\Models\Tag::class)->make()
//                    );
//                });

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