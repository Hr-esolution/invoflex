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

// Authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes protégées (authentification requise)
Route::middleware('auth')->group(function () {
    
    // Factures
    Route::resource('factures', FactureController::class);
    Route::get('/factures/{id}/pdf', [FactureController::class, 'facturePdf'])->name('factures.pdf');
    Route::post('/factures/{facture}/duplicate', [FactureController::class, 'duplicate'])->name('factures.duplicate');
    Route::post('/factures/{facture}/email', [FactureController::class, 'envoyerEmail'])->name('factures.email');
    Route::get('/factures/{id}/print', [FactureController::class, 'printable'])->name('factures.print');
    
    // Produits
    Route::resource('produits', ProduitController::class);
    Route::get('/api/produits', [FactureController::class, 'getProduits'])->name('api.produits');

    
    // Paramètres de facturation
    Route::get('/parametres/facturation', [FactureParametreController::class, 'edit'])->name('facturation.parametres.edit');
    Route::put('/parametres/facturation', [FactureParametreController::class, 'update'])->name('facturation.parametres.update');
    
    // Émetteur
    Route::get('/parametres/emetteur', [EmetteurController::class, 'edit'])->name('emetteur.edit');
    Route::put('/parametres/emetteur', [EmetteurController::class, 'update'])->name('emetteur.update');
    
    // Routes admin (accès restreint aux administrateurs)
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
        
        // Gestion des templates
        Route::resource('templates', FactureTemplateController::class)->except(['show'])->names([
            'index' => 'admin.templates.index',
            'create' => 'admin.templates.create',
            'store' => 'admin.templates.store',
            'edit' => 'admin.templates.edit',
            'update' => 'admin.templates.update',
            'destroy' => 'admin.templates.destroy',
        ]);
        
        // Gestion des champs
        Route::resource('champs', FactureChampController::class)->except(['show'])->names([
            'index' => 'admin.champs.index',
            'create' => 'admin.champs.create',
            'store' => 'admin.champs.store',
            'edit' => 'admin.champs.edit',
            'update' => 'admin.champs.update',
            'destroy' => 'admin.champs.destroy',
        ]);
        
        // Gestion des utilisateurs
        Route::resource('users', UserController::class)->only(['index', 'edit', 'update'])->names([
            'index' => 'admin.users.index',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
        ]);
    });
});



