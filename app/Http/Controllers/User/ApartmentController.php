<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Service;
use App\Message;
use App\Sponsorship;
use App\Apartment;
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
        $userLogged = Auth::id();
        $apartments = Apartment::where('user_id', '=', $userLogged)->get();
        return view('user.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();

        return view('user.apartments.create', compact('services'));
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

        $validator = Validator::make($data, [
            'title' => 'required|max:100',
            'rooms' => 'required|numeric|max:10|min:0',
            'beds' => 'required|numeric|max:20|min:0',
            'baths' => 'required|numeric|max:10|min:0',
            'mq' => 'required|numeric|max:1000|min:10',
            'services' => 'array',
            'services.*' => 'exists:services,id',
            'address' => 'required',
            'img_path' => 'required'

        ]);

        $path = Storage::disk('public')->put('images', $data['img_path']);
        $data['img_path'] = $path;


        if ($validator->fails()) {
            return redirect()->route('user.apartments.create')
                ->withErrors($validator)
                ->withInput();
        }


        $now = Carbon::now()->format('Y-m-d-H-i-s');
        $data['slug'] = Str::slug($data['title'], '-') . '-' . $now;

        $data['user_id'] = Auth::id();
        $apartment = new Apartment;
        $apartment->fill($data);
        $saved = $apartment->save();

        if (!$saved) {
            return redirect()->back()->withInput();;
        }

        if (isset($data['services'])) {
            $apartment->services()->attach($data['services']);
        }

        return redirect()->route('user.apartments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
