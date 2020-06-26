<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $exp_date = Carbon::now()->addHour($duration);
        $new_sponsorship->expiration_date = $exp_date;
        $new_sponsorship->save();

        // Sponsorizzazione attiva
        if(Apartment::find($data['apartId'])->activesponsorship()->exists()) { // se esiste
            $actual_exp_date = Apartment::find($data['apartId'])->activesponsorship->expiration_date; // stringa con il timestamp like 1593196142
            // $actual_exp_date = intval($actual_exp_date); // parsing della stringa in intero

            $new_from_actual_exp_date = new Carbon($actual_exp_date); // nuova istanza di Carbon a partire da un timestamp

            $active_sponsorship = DB::table('active_sponsorships')->where('apartment_id', $data['apartId']);
            // se il timestamp in expiration_date > now(), cioè se ancora la sponsorizzazione
            // è attiva, incremento il timestamp di un numero di ore pari a $request->input('radioVal')
            if ($new_from_actual_exp_date > now()) {
                $updated_exp_date = $new_from_actual_exp_date->addHour($duration)-> // aggiungo le ore della nuova sponsorizzazione
                $active_sponsorship->update(['expiration_date' => $updated_exp_date]);
            } else {
                // se la sponsorizzazione è scaduta sovrascrivo il timestamp con $exp_date (il timestamp di questo istante) e sommo le ore
                $new_exp_date = Carbon::now()->addHour($duration);
                $active_sponsorship->update(['expiration_date' => $new_exp_date]);
            }
        } else {
            // se non esiste la creo
            $new_active_sponsorship = new ActiveSponsorship;
            $new_active_sponsorship->apartment_id = $request->input('apartId');
            $exp_date = Carbon::now()->addHour($duration);
            $new_active_sponsorship->expiration_date = $exp_date;
            $new_active_sponsorship->save();
        }


        // DEVO AGGIUNGERE IL CONTROLLO:
        // se la sponsorizzazione è già attiva,
        // aggiornarla sommando al timestamp i giorni della nuova sponsorizzazione


        // attivo un evento di laravel per aggiornare la colonna updated_at
        // in questo modo Scout Extended che resta sempre in ascolto, capta l'evento
        // e aggiorna l'index di Algolia con il record 'exp_date'
        $apartment_to_touch = Apartment::find($request->input('apartId'));
        sleep(1); // addormento lo script per un secondo in modo che il save venga completato
        $apartment_to_touch->touch();

        return response('Success', 200)->header('Content-Type', 'text/plain');
        // $data = $request->input('id');

        // var_dump($request->all());
        // dd($request->all());


        // return view('user.apartments.show', 4);
        // return view('user.apartments.sponsorships');
    }
}
