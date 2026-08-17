<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventSponsor extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'sponsor_id',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }
}