<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{

    protected $fillable = [
        'user_id', 'apartment_id', 'ip_address', 'last_activity'
    ];

    public function apartments()
    {
        return $this->belongsTo('App\Apartment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
