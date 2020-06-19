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
        $this->services;

        $array = $this->toArray();

        $array = $this->transform($array);

        // $array['_geoloc'] = [
        //     'lat' => $this->select('latitude')->get(),
        //     'lng' => $this->select('longitude')->get()
        // ];
        $array['_geoloc'] = [
            'lat' => $array['latitude'],
            'lng' => $array['longitude']
        ];
        // $array['first_name'] = $this->user->first_name;
        // $array['sponsorship_'] = $this->author->email;

        return $array;
    }

}
