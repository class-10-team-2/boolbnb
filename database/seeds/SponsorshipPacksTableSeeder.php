<?php

use Illuminate\Database\Seeder;
use App\Sponsorship_pack;

class SponsorshipPacksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packs = [
            [
                'price' => '2.99',
                'duration' => '24'
            ],
            [
                'price' => '5.99',
                'duration' => '72'
            ],
            [
                'price' => '9.99',
                'duration' => '144'
            ]
        ];

        if (DB::table('sponsorship_packs')->count() != count($packs)) {
            foreach ($packs as $pack) {
                $new_pack = new Sponsorship_pack;
                $new_pack->price = $pack['price'];
                $new_pack->duration = $pack['duration'];
                $new_pack->save();
            }
        }
    }
}
