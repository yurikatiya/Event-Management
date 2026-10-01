<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DashboardCalendarNote extends Model
{
    protected $fillable = [
        'user_id',
        'note_date',
        'note',
    ];

    protected $casts = [
        'note_date' => 'date',
    ];
}