@extends('layouts.app')

@section('content')
<div class="card" style="text-align: center; max-width: 600px; margin: 60px auto;">
    <h1>Bienvenue sur InvoFlex</h1>
    <p>Le système de facturation flexible, international et personnalisable.</p>
    @guest
        <a href="{{ route('login') }}" class="btn" style="margin: 12px;">Se connecter</a>
        <a href="{{ route('register') }}" class="btn btn-outline">S'inscrire</a>
    @endguest
</div>
@endsection