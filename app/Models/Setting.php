<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    // Pas de $fillable classique car on utilise le nom de colonne 'key'
    protected $primaryKey = 'key';
    public $incrementing = false;

    protected $guarded = [];
    public $timestamps = false; 
}
