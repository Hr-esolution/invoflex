<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Afficher le formulaire de connexion
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Traiter la connexion
   // Traiter la connexion
public function login(Request $request)
{
    $request->validate([
        'identity' => 'required|string',
        'password' => 'required|string',
    ]);

    $field = filter_var($request->identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
    $credentials = [$field => $request->identity, 'password' => $request->password];

    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();

        // 🔁 Redirection selon le rôle
        if (Auth::user()->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        }

        return redirect()->intended('/factures');
    }

    return back()->withErrors([
        'identity' => 'Les identifiants ne correspondent pas.',
    ]);
}
    // Afficher le formulaire d'inscription
    public function showRegisterForm()
    {
        return view('auth.register');
    }

 

public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string|unique:users,phone',
        'password' => 'required|confirmed|min:8',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'role' => 'user',
    ]);

    Auth::login($user);

    // 🔁 Redirection selon le rôle (utile si plus tard un admin peut créer des comptes)
    if ($user->role === 'admin') {
        return redirect('/admin/dashboard');
    }

    return redirect('/factures');
}
    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}