<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Sponsorship;

class SponsorshipController extends Controller
{

    public function store_sponsorship(Request $request)
    {
        // $data = $request->input('id');

        dd($request->all());


        // return redirect()->route('user.apartments.show', $data->id);
        // return redirect()->route('user.apartments.show', 4);
    }

    public function view_sponsorship(Request $request)
    {
        // $data = $request->input('id');

        dd($request->all());


        return view('user.apartments.show', 4);
        // return view('user.apartments.sponsorships');
    }
}
