<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
  protected $fillable = [
    'name',
    'email',
    'phone',          // ← ajouté
    'password',
    'role', 
    'lang',   
     'google_drive_token',
    'google_drive_refresh_token',
    'google_drive_token_expires_at',       // ← ajouté
];
    // Accesseurs pratiques
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }
public function factureParametre()
{
    return $this->hasOne(FactureParametre::class);
}

public function produits()
{
    return $this->hasMany(Produit::class);
}

public function factures()
{
    return $this->hasMany(Facture::class);
}
// app/Models/User.php
public function emetteur()
{
    return $this->hasOne(Emetteur::class);
}
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
