<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'date_event', 'type', 'is_read'
    ];

    protected $casts = [
        'date_event' => 'date',
        'is_read' => 'boolean',
    ];
}