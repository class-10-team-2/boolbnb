<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Apartment;
use Carbon\Carbon;

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

// $factory->define(Apartment::class, function (Faker $faker) {

//     $title = $faker->realText($maxNbChars = 50, $indexSize = 2);
//     $now = Carbon::now()->format('Y-m-d-H-i-s');
//     $slug = Str::slug($title , '-') . '-' . $now;

//     return [
//         'user_id' => User::inRandomOrder()->first()->id,
//         'title' => $title,
//         'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
//         'slug' => $slug,
//         'rooms' => $faker->numberBetween($min = 1, $max = 10),
//         'beds' => $faker->numberBetween($min = 1, $max = 20),
//         'baths' => $faker->numberBetween($min = 1, $max = 10),
//         'mq' => $faker->randomFloat($nbMaxDecimals = 2, $min = 50, $max = 900),
//         'address' => $faker->address(),
//         'latitude' => $faker->latitude($min = -90, $max = 90),
//         'longitude' => $faker->longitude($min = -180, $max = 180),
//         'img_path' => 'https://picsum.photos/300/200?random=' . rand(1, 1000),
//         'visible' => rand(0, 1)
//     ];
// });
