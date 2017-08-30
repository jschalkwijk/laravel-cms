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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
    $factory->define(CMS\Models\Post::class, function (Faker\Generator $faker) {
        return [
            'post_id' => $faker->unique()->numberBetween(1,1000),
            'title' => $faker->sentence(8,40),
            'description' => $faker->text(50),
            'content' => $faker->paragraph(rand(3,5)),
            'approved' => $faker->boolean(),
            'trashed' => $faker->boolean(),
            'user_id' => 26,
            'category_id' => 1,
            'created_at' => $faker->dateTimeThisYear,
            'updated_at' => $faker->dateTimeThisYear,
        ];
    });

    /** @var \Illuminate\Database\Eloquent\Factory $factory */
    $factory->define(CMS\Models\Category::class, function (Faker\Generator $faker) {
        return [
            'category_id' => $faker->unique()->numberBetween(1,1000),
            'title' => $faker->sentence(1,40),
            'description' => $faker->text(50),
            'content' => $faker->paragraph(rand(3,5)),
            'approved' => $faker->boolean(),
            'trashed' => $faker->boolean(),
            'type' => 'post',
            'user_id' => 26,
            'parent_id' => 1,
            'created_at' => $faker->dateTimeThisYear,
            'updated_at' => $faker->dateTimeThisYear,
        ];
    });
