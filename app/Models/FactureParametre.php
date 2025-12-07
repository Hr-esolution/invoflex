<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureParametre extends Model
{
    protected $fillable = ['user_id', 'template_defaut_id', 'champs_actifs', 'mode_produit_defaut'];
    protected $casts = [
        'champs_actifs' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function templateDefaut()
    {
        return $this->belongsTo(FactureTemplate::class, 'template_defaut_id');
    }
}