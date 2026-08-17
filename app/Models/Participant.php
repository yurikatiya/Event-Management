<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'institution',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function events()
    {
        return $this->belongsToMany(
            Event::class,
            'registrations'
        )->withPivot([
            'status',
            'registered_at',
            'rejection_reason'
        ]);
    }
}