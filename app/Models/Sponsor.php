<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sponsor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'logo',
        'description',
    ];

    public function eventSponsors()
    {
        return $this->hasMany(EventSponsor::class);
    }

    public function events()
    {
        return $this->belongsToMany(
            Event::class,
            'event_sponsors'
        );
    }
}