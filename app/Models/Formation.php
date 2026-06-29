<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'date_debut', 'date_fin', 'formateur', 'status'
    ];

    // NOUVEAU : Ceci dit à Laravel de transformer les textes en vraies dates
    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];
}