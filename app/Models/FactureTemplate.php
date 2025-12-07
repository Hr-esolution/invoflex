<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureTemplate extends Model
{
    protected $fillable = ['code', 'nom_fr', 'nom_en', 'chemin_blade', 'actif'];
}