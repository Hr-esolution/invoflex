@extends('layouts.app')
@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Champs de facture</h1>
        <a href="{{ route('admin.champs.create') }}" class="btn">+ Nouveau champ</a>
    </div>

    @if(session('success'))
        <div style="background:#d4edda; padding:12px; border-radius:6px; margin-bottom:20px;">{{ session('success') }}</div>
    @endif

    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:#f8f9fa;">
                <th style="padding:12px; text-align:left;">Code</th>
                <th style="padding:12px; text-align:left;">Nom (FR)</th>
                <th style="padding:12px; text-align:left;">Type</th>
                <th style="padding:12px; text-align:left;">Description</th>
                <th style="padding:12px; text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($champs as $champ)
            <tr>
                <td style="padding:12px; border-bottom:1px solid #eee;">{{ $champ->code }}</td>
                <td style="padding:12px; border-bottom:1px solid #eee;">{{ $champ->nom_fr }}</td>
                <td style="padding:12px; border-bottom:1px solid #eee;">
                    @switch($champ->type)
                        @case('text')
                            <span class="badge" style="background:#e3f2fd; color:#1976d2; padding:4px 8px; border-radius:4px;">Texte</span>
                            @break
                        @case('number')
                            <span class="badge" style="background:#e8f5e9; color:#388e3c; padding:4px 8px; border-radius:4px;">Nombre</span>
                            @break
                        @case('date')
                            <span class="badge" style="background:#fff3e0; color:#f57c00; padding:4px 8px; border-radius:4px;">Date</span>
                            @break
                        @case('boolean')
                            <span class="badge" style="background:#f3e5f5; color:#7b1fa2; padding:4px 8px; border-radius:4px;">Booléen</span>
                            @break
                        @default
                            <span class="badge" style="background:#e0e0e0; color:#616161; padding:4px 8px; border-radius:4px;">{{ $champ->type }}</span>
                    @endswitch
                </td>
                <td style="padding:12px; border-bottom:1px solid #eee;">{{ $champ->description ?? '-' }}</td>
                <td style="padding:12px; border-bottom:1px solid #eee; text-align:right;">
                    <a href="{{ route('admin.champs.edit', $champ) }}" style="color:#4361ee; margin-right:10px;">✏️</a>
                    <form action="{{ route('admin.champs.destroy', $champ) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none; border:none; color:#dc3545; cursor:pointer;">🗑️</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $champs->links() }}
</div>
@endsection