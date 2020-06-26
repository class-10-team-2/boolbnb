<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActiveSponsorship extends Model
{
    protected $fillable = [
        'expiration_date', 'apartment_id'
    ];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['apartment'];

    /**
     * Get the apartment that the sponsorship belongs to.
     */
    public function apartment()
    {
        return $this->hasOne('App\Apartment');
    }
}
