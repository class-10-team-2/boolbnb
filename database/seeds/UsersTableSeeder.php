<?php

use Illuminate\Database\Seeder;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $users = [
            [
                'first_name' => 'Lorenzo',
                'last_name' => 'Lulli',
                'email' => 'lorenzo.lulli@email.it',
                'date_of_birth' => $faker->date($format = 'Y-m-d', $max = '1998'),
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'remember_token' => Str::random(10)
            ],
            [
                'first_name' => 'Francesco',
                'last_name' => 'Pagano',
                'email' => 'francesco.pagano@email.it',
                'date_of_birth' => $faker->date($format = 'Y-m-d', $max = '1998'),
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'remember_token' => Str::random(10)
            ],
            [
                'first_name' => 'Simone',
                'last_name' => 'Sala',
                'email' => 'simone.sala@email.it',
                'date_of_birth' => $faker->date($format = 'Y-m-d', $max = '1998'),
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'remember_token' => Str::random(10)
            ],
            [
                'first_name' => 'Davide',
                'last_name' => 'Roberti',
                'email' => 'davide.roberti@email.it',
                'date_of_birth' => $faker->date($format = 'Y-m-d', $max = '1998'),
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'remember_token' => Str::random(10)
            ],
            [
                'first_name' => 'Vanessa',
                'last_name' => 'Rossi',
                'email' => 'vanessa.rossi@email.it',
                'date_of_birth' => $faker->date($format = 'Y-m-d', $max = '1998'),
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'remember_token' => Str::random(10)
            ],
        ];
        //factory(User::class, 6)->create();

        foreach ($users as $user) {
            DB::table('users')->insert([
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'email' => $user['email'],
                'date_of_birth' => $user['date_of_birth'],
                'email_verified_at' => $user['email_verified_at'],
                'password' => $user['password'],
                'remember_token' => $user['remember_token'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
