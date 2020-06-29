<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Laravel\Scout\Searchable;

class Sponsorship extends Model
{
    // use Searchable;

    protected $fillable = [
        'expiration_date', 'apartment_id', 'sponsorship_pack_id'
    ];

    public function apartment()
    {
        return $this->belongsTo('App\Apartment');
    }
    public function sponsorship_pack()
    {
        return $this->belongsTo('App\Sponsorship_pack');
    }

    // INDICIZZAZIONE DELLE RELAZIONI PER ALGOLIA
    // public function toSearchableArray()
    // {
    //     // $this->services;
    //
    //     $array = $this->toArray();
    //
    //     $array = $this->transform($array);
    //
    //     // Creo il record _geoloc da inviare all'indice di Algolia.
    //     // Algolia ha bisogno che il record con lat e lng abbia questo nome
    //     // e come valore un oggetto di questo tipo: {lat: 11.111111, lng: 22.222222}
    //     // Qindi gli passo un array associativo che sarà convertito automaticamente
    //     //
    //     $array['_geoloc'] = [
    //         'lat' => $this->apartment->latitude,
    //         'lng' => $this->apartment->longitude
    //     ];
    //
    //     return $array;
    // }

}
