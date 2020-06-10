<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsorship_pack extends Model
{
    protected $fillable = [
        'price', 'duration'
    ];
    public function sponsorships()
    {
        return $this->hasMany('App\Sponsorship');
    }
}
