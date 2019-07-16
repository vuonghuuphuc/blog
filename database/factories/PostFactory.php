<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Post;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Post::class, function (Faker $faker) {

    return [
        'title' => $faker->jobTitle,
        'description' => $faker->realText,
        'body' => $faker->paragraph(50),
        'published_at' => Arr::random([null, now()]),
        'deleted_at' => Arr::random([null, now()]),
        'views' => Arr::random([null, rand(1,100)]),
        'image_url' => $faker->imageUrl,
        'user_id' => \App\User::inRandomOrder()->first()->id,
        'is_required_auth' => Arr::random([null, 1]),
    ];
});
