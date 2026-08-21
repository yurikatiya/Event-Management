<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'created_by',
        'name',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'address',
        'organizer',
        'quota',
        'poster',
        'status',
        'rejection_reason',
        'approved_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function participants()
    {
        return $this->belongsToMany(
            Participant::class,
            'registrations'
        )->withPivot([
            'status',
            'registered_at',
            'rejection_reason'
        ]);
    }

    public function eventSponsors()
    {
        return $this->hasMany(EventSponsor::class);
    }

    public function sponsors()
    {
        return $this->belongsToMany(
            Sponsor::class,
            'event_sponsors'
        );
    }
}
