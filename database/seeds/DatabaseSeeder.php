<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ApartmentsTableSeeder::class);

        $this->call(ServicesTableSeeder::class);
        $this->call(ApartmentServiceTableSeeder::class);
        $this->call(SponsorshipPacksTableSeeder::class);
        $this->call(ActiveSponsorshipsTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(SessionsTableSeeder::class);
    }
}
