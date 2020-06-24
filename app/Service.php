<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    // use Searchable;

    protected $fillable = [
        'name'
    ];

    public function apartments()
    {
        return $this->belongsToMany('App\Apartment');
    }
}
