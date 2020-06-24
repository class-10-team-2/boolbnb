<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActiveSponsorship extends Model
{
    protected $fillable = [
        'expiration_date', 'apartment_id'
    ];

    public function apartment()
    {
        return $this->hasOne('App\Apartment');
    }
}
