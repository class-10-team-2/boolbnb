<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Session;
use App\Service;
use App\Message;
use App\Sponsorship;
use App\Apartment;
use App\Sponsorship_pack;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ApartmentController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        //dd($this->route('guest.apartment'));
        $validator = Validator::make($data, [
            'sender' => 'required|max:50|email',
            'text' => 'required|max:1500',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $message = new Message;
        $message->sender = $data['sender'];
        $message->text = $data['text'];

        //$message->apartment_id = $data['apt_id']; $data[route($id)]; $request->path();
        $message->apartment_id = $data['apt_id'];

        $message->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $ip = $request->ip();
        $today = Carbon::now()->format('Y-m-d');

        $apart_visited_today_by_user = Session::where([['ip_address', '=', $ip], ['last_activity', '=', $today], ['apartment_id', '=', $id]])->get();


        if ($apart_visited_today_by_user->isEmpty()) {
            $session = new Session;
            $session->ip_address = $ip;
            $session->apartment_id = $id;
            $session->last_activity = $today;
            $session->user_id = Auth::id();

            $session->save();
        }
        //=============================================
        $apartment = Apartment::findOrFail($id);
        return view('guest.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
