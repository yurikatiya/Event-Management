<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'file_path',
        'caption',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}