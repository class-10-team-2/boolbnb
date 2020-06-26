<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        $query = ''; // usare questa variabile non è obbligatorio

        $rooms = $request->input('rooms');
        $beds = $request->input('beds');
        $radius = $request->input('radius');
        $latitude = $request->input('latitude');
        $logitude = $request->input('longitude');
        if (!empty($request->input('services'))) {
            $services = $request->input('services');
        } else {
            $services = [];
        }

        $apartments = Apartment::search($query)
                                    ->aroundLatLng($latitude, $logitude)
                                    ->with([
                                        'aroundRadius' => $radius*1000,
                                        'hitsPerPage' => 30,
                                    ])
                                    ->where('rooms', '>=', $rooms)
                                    ->where('beds', '>=', $beds)
                                    ->whereIn('services', $services)
                                    ->get();

        // Ritorna un json con i risultati filtrati
        // dd($apartments);
        return $apartments;
    }

    public function searchSponsored(Request $request)
    {
        // Ritorna un json con gli appartamenti sponsorizzati
        $query = ''; // usare questa variabile non è obbligatorio

        $rooms = $request->input('rooms');
        $beds = $request->input('beds');
        // $radius = $request->input('radius');
        $latitude = $request->input('latitude');
        $logitude = $request->input('longitude');
        if (!empty($request->input('services'))) {
            $services = $request->input('services');
        } else {
            $services = [];
        }

        $apartments = Apartment::search($query)
                                    ->aroundLatLng($latitude, $logitude)
                                    ->with([
                                        'aroundRadius' => 50000, // grande raggio di default
                                        'hitsPerPage' => 5,
                                    ])
                                    ->where('rooms', '>=', $rooms)
                                    ->where('beds', '>=', $beds)
                                    ->whereIn('services', $services)
                                    ->where('exp_date', '>', now())
                                    ->get();

        return $apartments;
    }

}
