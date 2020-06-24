<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Session;
use App\Service;
use App\Apartment;
use App\Sponsorship_pack;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


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
    public function store(Request $request , Apartment $apartment)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required|max:100',
            'description' => 'required|max:2500',
            'rooms' => 'required|numeric|max:10|min:0',
            'beds' => 'required|numeric|max:20|min:0',
            'baths' => 'required|numeric|max:10|min:0',
            'mq' => 'required|numeric|max:1000|min:10',
            'services' => 'array',
            'services.*' => 'exists:services,id',
            'address' => 'required',
            'img_path' => 'required'

        ]);

        if ($validator->fails()) {
            return redirect()->route('user.apartments.create')
                ->withErrors($validator)
                ->withInput();
        }

        $path = Storage::disk('public')->put('images', $data['img_path']);
        $data['img_path'] = $path;


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
            // $apartment->services()->attach($request->input('services'));
        }

        // $services = [
        //     'services' => $data['services']
        // ]
        //
        // $apartment->fill($data['services']);
        // $updated = $apartment->update();

        return redirect()->route('user.apartments.show', $apartment->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $apartment = Apartment::findOrFail($id);
        $user_id = Auth::id();
        if ($user_id != $apartment->user_id) {
            abort('404');
        }

        $sponsorship_packs = Sponsorship_pack::all();

        return view('user.apartments.show', compact('apartment', 'sponsorship_packs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $apartment = Apartment::findOrFail($id);
        $services = Service::all();
        $user_id = Auth::id();
        if ($user_id != $apartment->user_id) {
            abort('404');
        }
        return view('user.apartments.edit', compact('apartment', 'services'));
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
        $data = $request->all();
        $now = Carbon::now()->format('Y-m-d-H-i-s');
        $data['slug'] = Str::slug($data['title'], '-') . '-' . $now;
        $user_id = Auth::id();
        $apartment = Apartment::findOrFail($id);
        $author = $apartment->user->id;



        if ($user_id != $author) {
            abort('404');
        }

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


        if (empty($data['img_path'])) {
            unset($data['img_path']);
        } else {
            $path = Storage::disk('public')->put('images', $data['img_path']);
            $data['img_path'] = $path;
        }

        if (empty($data['services'])) {
            unset($data['services']);
            $apartment->services()->detach();
        } else {
            // $apartment->services()->sync($data['services']);
            $apartment->services()->sync($request->input('services'));
        }

        $apartment->fill($data);
        $updated = $apartment->update();

        if (!$updated) {
            return redirect()->back();
        }

        return redirect()->route('user.apartments.show', $apartment->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $apartment = Apartment::findOrFail($id);
        $user_id = Auth::id();
        if ($user_id != $apartment->user_id) {
            abort('404');
        }
        $apartment->services()->detach();
        $deleted = $apartment->delete();

        if (!$deleted) {
            return redirect()->back();
        }
        return redirect()->route('user.apartments.index');
    }


    public function stats(Request $request)
    {
        $apt_id = $request->input('apt_id');
        $sessions = Session::where([['apartment_id', '=', $apt_id]])->whereYear('last_activity', '=', Carbon::now('y'))->get();

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = Session::where('apartment_id', '=', $apt_id)->whereMonth('last_activity', '=', $i)->whereYear('last_activity', '=', Carbon::now('y'))->get();
            $month = $month->count();
            $months[] = $month;
        }
        //$feb = Session::where([['apartment_id', '=', $id],['last_activity', '=', Carbon::()]])->get();


        return response()->json($months);
    }

    public function view_stats($id)
    {
        $apartment = Apartment::findOrFail($id);

        $messages_count = DB::table('messages')->where('apartment_id', '=', $id)->count();

        return view('user.apartments.stats', compact('apartment', 'messages_count'));
    }

    public function view_messages($id, Request $request)
    {
        $apartment = Apartment::findOrFail($id);
        $messages = DB::table('messages')->where('apartment_id', '=', $id)->orderBy('created_at', 'DESC')->paginate(10);
        return view('user.apartments.messages', ['messages' => $messages], compact('apartment'));
    }

    // public function view_sponsorship(Request $request)
    // {
    //     // $data = $request->input('id');
    //
    //     dd($request->all());
    //
    //
    //     // return view('user.apartments.show', 4);
    //     // return view('user.apartments.sponsorships');
    // }
}
