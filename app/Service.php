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
}
