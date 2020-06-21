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
    public function index(Request $request)
    {
        $services = Service::all();
        // $form_data = $request->all(); // Request object

        // return view('guest.apartment.search', compact('form_data'));
        return view('guest.apartments.search', compact('services'));
    }

    public function search(Request $request)
    {
        // dd($request->all());

        // Intercetto il dati inviati dal form di ricerca nella home
        // e li uso per filtrare gli appartamenti usando
        // il metodo search() di Scout Extended
        $query = '';

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
                                    ->whereIn('services', $services)
                                    ->get();

        // Ritorna un json con i risultati filtrati
        return $apartments;

        // VECCHIO CODICE
        // $query = $request->all();
        //
        // return redirect()->route('search', $query);
    }



    // public function fromIndexToSearch(Request $request)
    // {
    //     $form_data = $request->all();
    //     return response()->json($request);
    // }
}
