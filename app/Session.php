<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{

    protected $fillable = [
        'user_id', 'ip_address', 'user_agent', 'payload', 'last_activity'
    ];

    public function apartments()
    {
        return $this->belongsToMany('App\Apartment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
