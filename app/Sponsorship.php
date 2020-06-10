<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
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
}
