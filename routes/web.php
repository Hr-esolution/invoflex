<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FactureParametreController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\FactureTemplateController;
use App\Http\Controllers\FactureChampController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmetteurController;



// Pages publiques
Route::get('/', function () {
    return view('welcome');
});
// Dans le groupe middleware auth
Route::middleware('auth')->group(function () {
    // Paramètres de facturation
    Route::get('/parametres/facturation', [FactureParametreController::class, 'edit'])
         ->name('facturation.parametres.edit');
    Route::put('/parametres/facturation', [FactureParametreController::class, 'update'])
         ->name('facturation.parametres.update');
Route::get('/api/produits', [FactureController::class, 'getProduits'])
     ->name('api.produits');
    // Émetteur
    Route::get('/parametres/emetteur', [EmetteurController::class, 'edit'])
         ->name('emetteur.edit');
    Route::put('/parametres/emetteur', [EmetteurController::class, 'update'])
         ->name('emetteur.update');
});
// Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// Admin uniquement
// Routes protégées
Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class)->only(['index', 'edit', 'update']);
    // Pour les utilisateurs
    Route::get('/factures', function () {
        return view('factures.index');
    })->name('factures.index');
    // ✅ Nouvelle route : paramètres de facturation
    Route::get('/parametres/facturation', [FactureParametreController::class, 'edit'])
        ->name('facturation.parametres');
    Route::put('/parametres/facturation', [FactureParametreController::class, 'update'])
        ->name('facturation.parametres.update');

Route::get('/api/produits', function () {
    return response()->json(auth()->user()->produits()->where('actif', true)->get([
        'id', 'nom', 'designation', 'prix_unitaire'
    ]));
})->name('api.produits');
 Route::resource('templates', FactureTemplateController::class)->except(['show']);
// routes/web.php
Route::post('/factures/{facture}/email', [FactureController::class, 'envoyerEmail'])
       ->name('factures.email');
       Route::get('/factures/{id}/print', [FactureController::class, 'printable'])
       ->name('factures.print');
Route::get('/produits/export', [ProduitController::class, 'exportCsv'])->name('produits.export');
Route::post('/factures/{facture}/duplicate', [FactureController::class, 'duplicate'])
       ->name('factures.duplicate');
Route::resource('champs', FactureChampController::class)->except(['show']);
    Route::get('/factures', [FactureController::class, 'index'])->name('factures.index');
    Route::get('/factures/create', [FactureController::class, 'create'])->name('factures.create');
    Route::post('/factures', [FactureController::class, 'store'])->name('factures.store');
    Route::get('/factures/{id}/pdf', [FactureController::class, 'facturePdf'])->name('factures.pdf');
    Route::resource('factures', FactureController::class);
    Route::get('/factures/{id}/pdf', [FactureController::class, 'facturePdf'])->name('factures.pdf');
    // Gestion des produits
Route::resource('produits', ProduitController::class);
    // Pour les admins
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });
});



