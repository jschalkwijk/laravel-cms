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
//$factory->define(CMS\Models\User::class, function (Faker\Generator $faker) {
//    static $password;
//
//    return [
//        'name' => $faker->name,
//        'email' => $faker->unique()->safeEmail,
//        'password' => $password ?: $password = bcrypt('secret'),
//        'remember_token' => str_random(10),
//    ];
//});
    $factory->define(CMS\Models\User::class, function (Faker\Generator $faker) {
        return [
            'user_id' => $faker->unique()->numberBetween(30,1000),
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'email' => $faker->companyEmail(),
            'password' => bcrypt('root'),
            'dob' => $faker->date(),
            'function' => $faker->randomElement('manager','programmer','hr','marketing'),
            'rights' => $faker->randomElement('Admin','Content Manager','Author'),
            'approved' => $faker->boolean(),
            'trashed' => $faker->boolean(),
            'remember_token' => $faker->text(100),
            'album_id' => 1,
            'img_path' => $faker->file('/uploads','/users').'/userfile.jpg',
            'created_by' => 26,
            'created_at' => $faker->dateTimeThisYear,
            'updated_at' => $faker->dateTimeThisYear,
        ];
    });

/** @var \Illuminate\Database\Eloquent\Factory $factory */
    $factory->define(CMS\Models\Post::class, function (Faker\Generator $faker) {
        $categories = \CMS\Models\Category::where('type','post')->pluck('category_id')->toArray();
        $users = \CMS\Models\User::all()->pluck('user_id')->toArray();
        return [
            'post_id' => $faker->unique()->numberBetween(1,1000),
            'title' => $faker->sentence(8,40),
            'description' => $faker->text(50),
            'content' => $faker->paragraph(rand(3,5)),
            'approved' => $faker->boolean(),
            'trashed' => $faker->boolean(),
            'user_id' => $faker->randomElement($users),
            'category_id' => $faker->randomElement($categories),
            'created_at' => $faker->dateTimeThisYear,
            'updated_at' => $faker->dateTimeThisYear,
        ];
    });

    /** @var \Illuminate\Database\Eloquent\Factory $factory */
    $factory->define(CMS\Models\Category::class, function (Faker\Generator $faker) {
        $users = \CMS\Models\User::all()->pluck('user_id')->toArray();
        $categories = \CMS\Models\Category::all()->pluck('category_id');
        if (count($categories) <= 4) {
            $categories = [0];
        } else {
            $categories = $categories->toArray();
        }
        return [
            'category_id' => $faker->unique()->numberBetween(1,1000),
            'title' => $faker->sentence(1,40),
            'description' => $faker->text(50),
            'content' => $faker->paragraph(rand(3,5)),
            'approved' => $faker->boolean(),
            'trashed' => $faker->boolean(),
            'type' => $faker->randomElement(['post','product']),
            'user_id' => $faker->randomElement($users),
            'parent_id' => $faker->randomElement($categories),
            'created_at' => $faker->dateTimeThisYear,
            'updated_at' => $faker->dateTimeThisYear,
        ];
    });

    $factory->define(\CMS\Models\Tag::class,function(\Faker\Generator $faker){
        $users = \CMS\Models\User::all()->pluck('user_id')->toArray();

        return [
            'tag_id' => $faker->unique()->numberBetween(1,1000),
            'title' => $faker->word(),
            'type' => $faker->randomElement(['post','product']),
            'user_id' => $faker->randomElement($users),
            'approved' => $faker->boolean(),
            'trashed' => $faker->boolean(),
            'created_at' => $faker->dateTimeThisYear,
            'updated_at' => $faker->dateTimeThisYear,

        ];
    });