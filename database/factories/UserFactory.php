<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.*/

$factory->define(User::class, function (Faker $faker) {
    // $names = array('Massimo', 'Luca', 'Sabrina', 'Lara', 'Giorgio', 'Fabrizio', 'Marina', 'Paola', 'Valeria', 'Marco', 'Nicola', 'Luigi', 'Valentina', 'Fiorenza', 'Miriam', 'Ugo', 'Alicia', 'Sofia', 'Simona', 'Andrea', 'Valerio');
    // $last_names = array('Zorzi', 'Natali', 'Zocchi', 'Riccardi', 'Vitiello', 'Cosimi', 'Belloni', 'Linetti', 'Fazio', 'Fasolo', 'Albini', 'Bergonzi', 'Sassetti', 'Marchi', 'Corsetti', 'Linarolo', 'Altaspina', 'Bellani', 'Wu', 'Segre', 'Talone', 'Santini');
    // $this_name = $names[array_rand($names, 1)];
    // $this_last_name = $last_names[array_rand($last_names, 1)];


    return [
        // 'first_name' => $this_name,
        // 'last_name' => $this_last_name,
        // 'email' => strtolower($this_name) . '.' . strtolower($this_last_name) . '@' . 'email.it',
        // 'date_of_birth' => $faker->dateTimeBetween($startDate = '01/01/1950', $endDate = '12/31/2001', $timezone = 'Europe/Rome'),
        // 'email_verified_at' => now(),
        // 'password' => Hash::make('12345678'), // password
        // 'remember_token' => Str::random(10),
    ];
});
