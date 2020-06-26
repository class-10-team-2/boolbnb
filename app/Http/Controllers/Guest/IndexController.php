<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\User;
use App\Session;
use App\ActiveSponsorship;
use App\Apartment;
use App\Sponsorship_pack;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Algolia\ScoutExtended\Facades\Algolia;

use App\Service;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();
        $apartments = Apartment::all();
        $active_sponsorships = ActiveSponsorship::all();
        $now = Carbon::now();

        return view('guest.index', compact('services','apartments','active_sponsorships','now'));
    }
}
