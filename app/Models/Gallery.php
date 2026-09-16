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
        'title',
        'caption',
        'description',
        'status',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}