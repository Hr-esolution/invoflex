@extends('layouts.app')
@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Utilisateurs</h1>
    </div>

    @if(session('success'))
        <div style="background:#d4edda; padding:12px; border-radius:6px; margin-bottom:20px;">{{ session('success') }}</div>
    @endif

    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:#f8f9fa;">
                <th style="padding:12px; text-align:left;">Nom</th>
                <th style="padding:12px; text-align:left;">Email</th>
                <th style="padding:12px; text-align:left;">Téléphone</th>
                <th style="padding:12px; text-align:left;">Rôle</th>
                <th style="padding:12px; text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td style="padding:12px; border-bottom:1px solid #eee;">{{ $user->name }}</td>
                <td style="padding:12px; border-bottom:1px solid #eee;">{{ $user->email }}</td>
                <td style="padding:12px; border-bottom:1px solid #eee;">{{ $user->phone ?? '-' }}</td>
                <td style="padding:12px; border-bottom:1px solid #eee;">
                    <span class="user-role role-{{ $user->role }}">{{ $user->role === 'admin' ? 'Administrateur' : 'Utilisateur' }}</span>
                </td>
                <td style="padding:12px; border-bottom:1px solid #eee; text-align:right;">
                    <a href="{{ route('admin.users.edit', $user) }}" style="color:#4361ee;">✏️</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
@endsection