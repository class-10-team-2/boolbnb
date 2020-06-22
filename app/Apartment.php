<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Apartment extends Model
{
    use Searchable;

    protected $fillable = [
        'title', 'description', 'slug', 'rooms', 'beds', 'baths', 'mq', 'address', 'longitude', 'latitude', 'img_path', 'visible', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function sponsorships()
    {
        return $this->hasMany('App\Sponsorship');
    }
    public function request()
    {
        return $this->hasMany('App\Message');
    }
    public function services()
    {
        return $this->belongsToMany('App\Service');
    }

    // INDICIZZAZIONE DELLE RELAZIONI PER ALGOLIA
    public function toSearchableArray()
    {
        // $this->services;

        $array = $this->toArray();

        $array = $this->transform($array);

        // Creo il record _geoloc da inviare all'indice di Algolia.
        // Algolia ha bisogno che il record con lat e lng abbia questo nome
        // e come valore un oggetto di questo tipo: {lat: 11.111111, lng: 22.222222}
        // Qindi gli passo un array associativo che sarà convertito automaticamente
        $array['_geoloc'] = [
            'lat' => $array['latitude'],
            'lng' => $array['longitude']
        ];

        $array['services'] = $this->services->map(function($data) {
            return $data['id'];
        })->toArray();
        // $array['first_name'] = $this->user->first_name;
        // $array['sponsorship_'] = $this->author->email;

        return $array;
    }

}
