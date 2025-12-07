<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = ['user_id', 'nom', 'designation', 'prix_unitaire', 'categorie', 'actif'];
    protected $casts = [
        'prix_unitaire' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}