<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = [
        'sender', 'message', 'apartment_id'
    ];

    public function apartment()
    {
        return $this->belongsTo('App\Apartment');
    }
}
