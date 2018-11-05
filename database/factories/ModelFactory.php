<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
    $factory->define(JornSchalkwijk\LaravelCMS\Models\User::class, function (Faker\Generator $faker) {
        return [
            'user_id' => $faker->unique()->numberBetween(50,1000),
            'username' => $faker->userName(),
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'email' => $faker->companyEmail(),
            'password' => bcrypt('root'),
            'dob' => $faker->date(),
            'function' => $faker->randomElement(['manager','programmer','hr','marketing']),
            'approved' => $faker->randomElement([0,1]),
            'trashed' => $faker->randomElement([0,1]),
            'remember_token' => str_random(10),
            'created_at' => $faker->dateTimeThisYear,
            'updated_at' => $faker->dateTimeThisYear,
        ];
    });

/** @var \Illuminate\Database\Eloquent\Factory $factory */
    $factory->define(JornSchalkwijk\LaravelCMS\Models\Post::class, function (Faker\Generator $faker) {
        $categories = \JornSchalkwijk\LaravelCMS\Models\Category::where('type','post')->pluck('category_id')->toArray();
        $users = \JornSchalkwijk\LaravelCMS\Models\User::all()->pluck('user_id')->toArray();
        return [
            'post_id' => $faker->unique()->numberBetween(1,1000),
            'title' => $faker->sentence(8,40),
            'description' => $faker->text(50),
            'content' => $faker->paragraph(rand(3,5)),
            'approved' => $faker->randomElement([0,1]),
            'trashed' => $faker->randomElement([0,1]),
            'user_id' => $faker->randomElement($users),
            'category_id' => $faker->randomElement($categories),
            'created_at' => $faker->dateTimeThisYear,
            'updated_at' => $faker->dateTimeThisYear,
        ];
    });

    /** @var \Illuminate\Database\Eloquent\Factory $factory */
    $factory->define(JornSchalkwijk\LaravelCMS\Models\Category::class, function (Faker\Generator $faker) {
        $users = \JornSchalkwijk\LaravelCMS\Models\User::all()->pluck('user_id')->toArray();
        $categories = \JornSchalkwijk\LaravelCMS\Models\Category::all()->pluck('category_id');
        if ($categories->count() < 1) {;
            return [
                'category_id' => $faker->unique()->numberBetween(1,1000),
                'title' => $faker->sentence(1,40),
                'description' => $faker->text(50),
                'content' => $faker->paragraph(rand(3,5)),
                'approved' => $faker->randomElement([0,1]),
                'trashed' => $faker->randomElement([0,1]),
                'type' => $faker->randomElement(['post','product']),
                'user_id' => $faker->randomElement($users),
                'parent_id' => 0,
                'created_at' => $faker->dateTimeThisYear,
                'updated_at' => $faker->dateTimeThisYear,
            ];
        } else {
            $categories = JornSchalkwijk\LaravelCMS\Models\Category::all()->pluck('category_id')->toArray();
            return [
                'category_id' => $faker->unique()->numberBetween(1,1000),
                'title' => $faker->sentence(1,40),
                'description' => $faker->text(50),
                'content' => $faker->paragraph(rand(3,5)),
                'approved' => $faker->randomElement([0,1]),
                'trashed' => $faker->randomElement([0,1]),
                'type' => $faker->randomElement(['post','product']),
                'user_id' => $faker->randomElement($users),
                'parent_id' => $faker->randomElement($categories),
                'created_at' => $faker->dateTimeThisYear,
                'updated_at' => $faker->dateTimeThisYear,
            ];
        }

    });

    $factory->define(JornSchalkwijk\LaravelCMS\Models\Product::class, function (Faker\Generator $faker) {
        $categories = JornSchalkwijk\LaravelCMS\Models\Category::where('type','product')->pluck('category_id')->toArray();
        return [
            'product_id' => $faker->unique()->numberBetween(1,1000),
            'name' => $faker->sentence(8,40),
            'description' => $faker->text(50),
            'price' => 10,
            'quantity' => 10,
            'discount_price' => 0.00,
            'savings' => 0.00,
            'tax_percentage' => 21,
            'tax' => 0.00,
            'img_path' => $faker->file(storage_path('app/public/uploads','/products')),
            'category_id' => $faker->randomElement($categories),
            'folder_id' => 0,
            'approved' => $faker->randomElement([0,1]),
            'trashed' => $faker->randomElement([0,1]),
            'created_at' => $faker->dateTimeThisYear,
            'updated_at' => $faker->dateTimeThisYear,
        ];
    });

    $factory->define(\JornSchalkwijk\LaravelCMS\Models\Tag::class,function(\Faker\Generator $faker){
        $users = \JornSchalkwijk\LaravelCMS\Models\User::all()->pluck('user_id')->toArray();
        return [
            'tag_id' => $faker->unique()->numberBetween(1,1000),
            'title' => $faker->word(),
            'type' => $faker->randomElement(['post','product']),
            'user_id' => $faker->randomElement($users),
            'approved' => $faker->randomElement([0,1]),
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTimeThisYear,
        ];
    });