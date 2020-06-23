<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Apartment;
use App\Service;

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
        $query = ''; // usare questa variabile non è obbligatorio

        $rooms = $request->input('rooms');
        $beds = $request->input('beds');
        $radius = $request->input('radius');
        $latitude = $request->input('latitude');
        $logitude = $request->input('longitude');
        $services = $request->input('services');
        // var_dump($latitude);
        $apartments = Apartment::search($query)
                                    ->aroundLatLng($latitude, $logitude)
                                    ->with([
                                        'aroundRadius' => $radius*1000,
                                        'hitsPerPage' => 30,
                                    ])
                                    ->where('rooms', '>=', $rooms)
                                    ->where('beds', '>=', $beds)
                                    // ->whereIn('services', $services)
                                    ->get();

        // Ritorna un json con i risultati filtrati
        return $apartments;
    }

}
