@extends('layouts.app')
@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Templates de facture</h1>
        <a href="{{ route('admin.templates.create') }}" class="btn">+ Nouveau template</a>
    </div>

    @if(session('success'))
        <div style="background:#d4edda; padding:12px; border-radius:6px; margin-bottom:20px;">{{ session('success') }}</div>
    @endif

    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:#f8f9fa;">
                <th style="padding:12px; text-align:left;">Code</th>
                <th style="padding:12px; text-align:left;">Nom (FR)</th>
                <th style="padding:12px; text-align:left;">Chemin Blade</th>
                <th style="padding:12px; text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($templates as $t)
            <tr>
                <td style="padding:12px; border-bottom:1px solid #eee;">{{ $t->code }}</td>
                <td style="padding:12px; border-bottom:1px solid #eee;">{{ $t->nom_fr }}</td>
                <td style="padding:12px; border-bottom:1px solid #eee;">{{ $t->chemin_blade }}</td>
                <td style="padding:12px; border-bottom:1px solid #eee; text-align:right;">
                    <a href="{{ route('admin.templates.edit', $t) }}" style="color:#4361ee; margin-right:10px;">✏️</a>
                    <form action="{{ route('admin.templates.destroy', $t) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none; border:none; color:#dc3545; cursor:pointer;">🗑️</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $templates->links() }}
</div>
@endsection