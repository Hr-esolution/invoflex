<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Facture extends Model
{
    protected $fillable = [
        'user_id',
        'client_nom',
        'client_tel',
        'client_adresse',
        'client_ice',
        'tva_applicable',
        'total_ht',
        'tva',
        'total_ttc',
        'lignes',
        'template_id',
        'valeurs_champs',
        'pdf_path',
    ];

    protected $casts = [
        'tva_applicable' => 'boolean',
        'lignes'         => 'array',
        'valeurs_champs' => 'array',
        'total_ht'       => 'decimal:2',
        'tva'            => 'decimal:2',
        'total_ttc'      => 'decimal:2',
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(FactureTemplate::class);
    }
}