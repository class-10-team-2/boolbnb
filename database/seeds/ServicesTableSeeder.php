<?php

use Illuminate\Database\Seeder;
use App\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            'WiFi',
            'Posto Auto',
            'Piscina',
            'Portineria',
            'Sauna',
            'Vista Mare'
        ];

        if (DB::table('services')->count() != count($services)) {
            foreach ($services as $service) {
                $new_service = new Service;
                $new_service->name = $service;
                $new_service->save();
            }
        }


    }
}
