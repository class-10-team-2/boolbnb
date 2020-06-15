<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Apartment;

class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        factory(Apartment::class, 50)->create();
    }
}
