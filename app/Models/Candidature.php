<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    use HasFactory;

    // Les champs qu'on a le droit de remplir
    protected $fillable = [
        'job_id', 'first_name', 'last_name', 'email', 'phone', 'cv_path', 'status'
    ];

    // Relation : Une candidature appartient à une offre d'emploi
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}