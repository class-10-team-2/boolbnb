<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Apartment extends Model
{
    use Searchable;

    protected $fillable = [
        'title', 'description', 'slug', 'rooms', 'beds', 'baths', 'mq', 'address', 'longitude', 'latitude', 'img_path', 'visible', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function sponsorships()
    {
        return $this->hasMany('App\Sponsorship');
    }
    public function request()
    {
        return $this->hasMany('App\Message');
    }
    public function services()
    {
        return $this->belongsToMany('App\Service');
    }
}
