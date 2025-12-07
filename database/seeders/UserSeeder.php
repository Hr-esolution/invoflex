<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'name' => 'Administrateur',
            'email' => 'admin@invoflex.test',
            'phone' => '0612345678',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Utilisateur standard
        User::factory()->create([
            'name' => 'Utilisateur Test',
            'email' => 'user@invoflex.test',
            'phone' => '0687654321',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        // Tu peux en ajouter d'autres
        // User::factory()->count(5)->create(['role' => 'user']);
    }
}