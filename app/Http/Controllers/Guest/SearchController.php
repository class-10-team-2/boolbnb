<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $address = $request->input('address');
        dd($address);
    }
}
