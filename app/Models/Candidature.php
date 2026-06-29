<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id', 'first_name', 'last_name', 'email', 'phone', 'cv_path', 'status', 'notes', 'onboarding_data'
    ];

    // Convertit automatiquement le JSON en tableau PHP pour qu'on puisse le manipuler facilement
    protected $casts = [
        'onboarding_data' => 'array',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}