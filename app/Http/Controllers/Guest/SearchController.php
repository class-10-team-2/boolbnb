<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Apartment;
use App\Service;
use App\Sponsorship;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();

        return view('guest.apartments.search', compact('services'));
    }

    public function search(Request $request)
    {
        // Intercetto il dati inviati dal form di ricerca nella home
        // e li uso per filtrare gli appartamenti usando
        // il metodo search() di Scout Extended
        // $query = ''; // usare questa variabile non è obbligatorio

        $is_sponsored = $request->input('is_sponsored');

        $rooms = $request->input('rooms');
        $beds = $request->input('beds');
        $radius = $request->input('radius');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        $services = $request->input('services');

        // $is_sponsored = 1;
        //
        // $rooms = 11;
        // $beds = 10;
        // $radius = 20;
        // $latitude = 45.28;
        // $longitude = 9.10;
        //
        // $services = [];


        // input del form
        $lat1 = $latitude;
        $lon1 = $longitude;

        // controllo sponsorizzati

        if ($is_sponsored == 1) {
            $prefiltered_apartments = Apartment::has('activesponsorship')
                ->where('rooms', '>=', $rooms)
                ->where('beds', '>=', $beds)
                // ->where('beds', '<', ($beds + 6))
                ->where('visible', 1)
                ->get()
                ->toArray();
        } else {
            $prefiltered_apartments = Apartment::doesntHave('activesponsorship')
                ->where('rooms', '>=', $rooms)
                ->where('beds', '>=', $beds)
                // ->where('beds', '<', ($beds + 6))
                ->where('visible', 1)
                ->get()
                ->toArray();
        }
        // dd($prefiltered_apartments);
        // dd($apartments);
        $filtered = []; // definisco l'array vuoto prima per evitare errori undefined quando richiamo json
        // cicliamo gli appartamenti filtrandoli per $radius
        if (!empty($prefiltered_apartments)) {
            foreach ($prefiltered_apartments as $apartment) {
                $lat2 = $apartment['latitude'];
                $lon2 = $apartment['longitude'];

                $R = 6371e3; //mt
                $φ1 = ($lat1 * pi()) / 180; // φ, λ in radians
                $φ2 = ($lat2 * pi()) / 180;
                $Δφ = (($lat2 - $lat1) * pi()) / 180;
                $Δλ = (($lon2 - $lon1) * pi()) / 180;
                $a =
                    sin($Δφ / 2) * sin($Δφ / 2) +
                    cos($φ1) * cos($φ2) * sin($Δλ / 2) * sin($Δλ / 2);
                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                $d = ($R * $c) / 1000; // distanza fra coordinate iniziali e coordinate degli appartamenti


                if ($d <= $radius) {
                    $apartment['distance'] = $d;
                    $filtered[] = $apartment; // appartamenti localizzati all'interno del raggio (distanza)
                }
            }
        }

        if (!empty($services)) {
            foreach ($services as $service) {
                foreach ($filtered as $key => $apt_result) {
                    $apt_services = DB::table('apartment_service')->where('apartment_id', $apt_result['id'])->pluck('service_id')->toArray();
                    if (!in_array($service, $apt_services)) {
                        unset($filtered[$key]);
                    }
                }
            }

            return response()->json($filtered);
        } else {
            return response()->json($filtered);
        }


        // ALGOLIA ////////////////////////////////////////////////////////////

        // $apartments = Apartment::search($query)
        //                             ->aroundLatLng($latitude, $longitude)
        //                             ->with([
        //                                 'aroundRadius' => $radius*1000,
        //                                 'hitsPerPage' => 30,
        //                             ])
        //                             ->where('rooms', '>=', $rooms)
        //                             ->where('beds', '>=', $beds)
        //                             // ->where('services', '=', $services)
        //                             // ->whereIn('services.id['. 1 .']', $services)
        //                             // ->whereIn('services', $services)
        //                             ->where('visible', 1)
        //                             ->get();
        //
        // // Ritorna un json con i risultati filtrati
        // // dd($apartments);
        // return $apartments;
    }

    // public function searchSponsored(Request $request)
    // {
    //     // Ritorna un json con gli appartamenti sponsorizzati
    //     $query = ''; // usare questa variabile non è obbligatorio
    //
    //     $rooms = $request->input('rooms');
    //     $beds = $request->input('beds');
    //     // $radius = $request->input('radius');
    //     $latitude = $request->input('latitude');
    //     $logitude = $request->input('longitude');
    //     if (!empty($request->input('services'))) {
    //         $services = $request->input('services');
    //     } else {
    //         $services = [];
    //     }
    //
    //     // $apartments = Apartment::search($query)
    //     //                             ->aroundLatLng($latitude, $logitude)
    //     //                             ->with([
    //     //                                 'aroundRadius' => 50000, // grande raggio di default
    //     //                                 'hitsPerPage' => 5,
    //     //                             ])
    //     //                             ->where('rooms', '>=', $rooms)
    //     //                             ->where('beds', '>=', $beds)
    //     //                             // ->whereIn('services', $services)
    //     //                             ->where('exp_date', '>', now())
    //     //                             ->where('visible', 1)
    //     //                             ->get();
    //     //
    //     // return $apartments;
    // }
}
