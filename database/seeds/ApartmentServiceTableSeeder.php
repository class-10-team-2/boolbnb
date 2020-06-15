<?php

use Illuminate\Database\Seeder;

use App\Apartment;
use App\Service;

class ApartmentServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Recupero tutti gli id dei servizi,
        // il metodo pluck() ritorna un oggetto con gli id
        // quindi lo trasformo in un array
        $services = Service::all()->pluck('id')->toArray();

        $apartments = Apartment::all();
        // $apartments = Apartment::all()->toArray();

        foreach ($apartments as $apartment) {

            // Numero random che servirà per definire quante chiavi random prendere dall'array $services
            $rand_value = mt_rand(0, count($services));

            $rand_services = [];

            // Se non devo aggiungere servizi salto l'appartamento.
            // Inolte la funzione array_rand non accetta 0 come secondo argomento.
            if ($rand_value > 0) {
                // Prende le chiavi random in base al numero definito in precedenza
                $rand_keys = array_rand($services, $rand_value);

                if (is_array($rand_keys)) {
                    $rand_keys[] = $rand_keys[0];
                    unset($rand_keys[0]);
                }

                // Ciclo le chiavi random e pusho i servizi associati ad esse
                // foreach ($rand_keys as $rand_key) {
                //     $rand_services[] = $services[$rand_key];
                // }

                if (is_array($rand_keys)) {
                    for ($i=1; $i <= count($rand_keys); $i++) {
                        $rand_services[] = $services[$rand_keys[$i]];
                    }
                    $apartment->services()->attach($rand_services);
                } else {
                    $apartment->services()->attach($rand_keys);
                }
            }
        }
    }
}
