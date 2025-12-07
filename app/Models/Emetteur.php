<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emetteur extends Model
{
    protected $fillable = [
        'user_id',
        'nom_entreprise',
        'adresse',
        'ville',
        'code_postal',
        'pays',
        'telephone',
        'email',
        'ice',
        'rc',
        'patente',
        'cnss',
        'logo_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}