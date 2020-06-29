<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\ActiveSponsorship;
use App\Apartment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SessionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i <= 13; $i++) {
            for ($j = 0; $j < 1200; $j++) {
                DB::table('sessions')->insert([
                    'apartment_id' => $i,
                    'ip_address' => $faker->ipv4,
                    'last_activity' => $faker->dateTimeBetween($startDate = '-1 year', $endDate = 'now', $timezone = 'Europe/Rome'),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
        }
    }
}
