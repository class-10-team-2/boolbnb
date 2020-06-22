<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Service extends Model
{
    use Searchable;

    protected $fillable = [
        'name'
    ];

    public function apartments()
    {
        return $this->belongsToMany('App\Apartment');
    }

    // INDICIZZAZIONE DELLE RELAZIONI PER ALGOLIA
    public function toSearchableArray()
    {
        $this->apartments;

        $array = $this->toArray();

        $array = $this->transform($array);

        // $array['first_name'] = $this->user->first_name;
        // $array['sponsorship_'] = $this->author->email;

        return $array;
    }
}
