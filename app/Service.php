<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Laravel\Scout\Searchable;

class Service extends Model
{
    // use Searchable;

    protected $fillable = [
        'name'
    ];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    // protected $touches = ['apartments'];


    public function apartments()
    {
        return $this->belongsToMany('App\Apartment');
    }

    // INDICIZZAZIONE DELLE RELAZIONI PER ALGOLIA
    public function toSearchableArray()
    {
        // $this->services;

        $array = $this->toArray();

        $array = $this->transform($array);

        return $array;
    }
}
