<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'department', 'type', 'location', 'description', 'requirements', 'status'
    ];
    protected $dates = ['verified_at'];

}