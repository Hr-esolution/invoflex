@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="card">
    <h1>Tableau de bord Admin</h1>
    <p>Gérer les paramètres globaux de l'application InvoFlex.</p>

    <div style="margin-top: 24px; display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px;">
        <div style="border: 1px solid #e0e0e0; border-radius: 10px; padding: 20px; text-align: center;">
            <i class="fas fa-file-invoice" style="font-size: 28px; color: #4361ee;"></i>
            <h3 style="margin: 12px 0;">Templates</h3>
            <p>Créer ou modifier les modèles de facture.</p>
            <a href="#" class="btn" style="margin-top: 8px;">Gérer</a>
        </div>
        <div style="border: 1px solid #e0e0e0; border-radius: 10px; padding: 20px; text-align: center;">
            <i class="fas fa-globe" style="font-size: 28px; color: #4361ee;"></i>
            <h3 style="margin: 12px 0;">Champs</h3>
            <p>Gérer les champs internationaux.</p>
            <a href="#" class="btn" style="margin-top: 8px;">Gérer</a>
        </div>
        <div style="border: 1px solid #e0e0e0; border-radius: 10px; padding: 20px; text-align: center;">
            <i class="fas fa-users" style="font-size: 28px; color: #4361ee;"></i>
            <h3 style="margin: 12px 0;">Utilisateurs</h3>
            <p>Gérer les comptes utilisateurs.</p>
            <a href="#" class="btn" style="margin-top: 8px;">Gérer</a>
        </div>
    </div>
</div>
@endsection