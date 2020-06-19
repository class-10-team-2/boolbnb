<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Apartment;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $form_data = $request->all(); // Request object

        // return view('guest.search', compact('form_data'));
    }

    public function search(Request $request)
    {
        // dd($request->all());

        // Intercetto il dati inviati dal form di ricerca nella home
        // e li uso per filtrare gli appartamenti usando
        // il metodo search() di Scout Extended
        // $query = $request->all();
        $query = '';

        $rooms = $request->input('rooms');
        $beds = $request->input('beds');
        $radius = $request->input('radius');
        $latitude = $request->input('latitude');
        $logitude = $request->input('longitude');

        $apartments = Apartment::search($query)
                                    ->aroundLatLng($latitude, $logitude)
                                    ->with([
                                        // 'aroundLatLng' => $latitude, $logitude,
                                        'aroundRadius' => $radius*1000
                                    ])
                                    ->where('rooms', '>=', $rooms)
                                    ->where('rooms', '>=', $beds)
                                    // ->where([
                                    //     ['rooms', '>=', $rooms],
                                    //     ['beds', '>=', $beds]
                                    // ])
                                    ->get();

        // return response()->json($apartments);
        return $apartments;

        // VECCHIO CODICE
        // $query = $request->all();
        //
        // return redirect()->route('search', $query);
    }
}
