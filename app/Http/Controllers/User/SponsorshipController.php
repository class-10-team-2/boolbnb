<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use App\Sponsorship;
use App\Apartment;
use App\Sponsorship_pack;
use App\ActiveSponsorship;

class SponsorshipController extends Controller
{

    public function store_sponsorship(Request $request)
    {

        $data = $request->all();

        // Storia delle sponsorizzazioni
        $new_sponsorship = new Sponsorship;
        $new_sponsorship->apartment_id = $data['apartId'];
        $new_sponsorship->sponsorship_pack_id = $data['radioVal'];
        $sponsorship_checked = Sponsorship_pack::findOrFail($data['radioVal']);
        $duration = $sponsorship_checked->duration;
        // $exp_date = Carbon::now()->addHour($duration)->format('Y-m-d-H-i-s');
        $exp_date = Carbon::now()->addHour($duration)->timestamp;
        $new_sponsorship->expiration_date = $exp_date;
        $new_sponsorship->save();

        // Sponsorizzazione attiva
        $new_active_sponsorship = new ActiveSponsorship;
        $new_active_sponsorship->apartment_id = $request->input('apartId');
        $exp_date = Carbon::now()->addHour($duration)->timestamp;
        $new_active_sponsorship->expiration_date = $exp_date;
        $new_active_sponsorship->save();

        return response('Success', 200)->header('Content-Type', 'text/plain');
        // $data = $request->input('id');

        // var_dump($request->all());
        // dd($request->all());


        // return view('user.apartments.show', 4);
        // return view('user.apartments.sponsorships');
    }
}
