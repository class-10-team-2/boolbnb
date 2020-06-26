<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\ActiveSponsorship;
use App\Apartment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ActiveSponsorshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 3; $i <= 7; $i++) {
            DB::table('active_sponsorships')->insert([
                'apartment_id' => $i,
                'expiration_date' => '2025-05-02 16:32:15',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
