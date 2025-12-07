<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'InvoFlex')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', system-ui, sans-serif; }
        body { background: #f8f9fa; }
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 0 24px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .navbar-brand {
            font-size: 22px;
            font-weight: 700;
            color: #4361ee;
            text-decoration: none;
        }
        .nav-links {
            display: flex;
            gap: 24px;
            align-items: center;
        }
        .nav-links a {
            text-decoration: none;
            color: #495057;
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 6px;
            transition: background 0.2s;
        }
        .nav-links a:hover, .nav-links a.active {
            background: #eef2ff;
            color: #4361ee;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            color: #495057;
        }
        .user-role {
            background: #e9ecef;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 12px;
            text-transform: uppercase;
        }
        .role-admin { background: #e3f2fd; color: #1976d2; }
        .role-user { background: #f1f3f5; color: #495057; }
        .container {
            max-width: 1200px;
            margin: 32px auto;
            padding: 0 24px;
        }
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 32px;
        }
        .card h1 {
            font-size: 28px;
            color: #212529;
            margin-bottom: 16px;
        }
        .card p {
            color: #6c757d;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            background: #4361ee;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 16px;
        }
        .btn:hover {
            background: #3a56e4;
        }
        .btn-outline {
            background: transparent;
            border: 1px solid #4361ee;
            color: #4361ee;
        }
        .btn-outline:hover {
            background: #f0f4ff;
        }
    </style>
</head>
<body>
    @auth
        <nav class="navbar">
            <a href="{{ route('factures.index') }}" class="navbar-brand">InvoFlex</a>
            <div class="nav-links">
                <a href="{{ route('factures.index') }}">Mes Factures</a>
                 <a href="{{ route('produits.index') }}">Produits</a>
                <a href="{{ route('facturation.parametres') }}">Paramètres</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}">Admin</a>
                @endif
            </div>
            <div class="user-info">
                <span>{{ auth()->user()->name }}</span>
                <span class="user-role role-{{ auth()->user()->role }}">
                    {{ auth()->user()->role === 'admin' ? 'Administrateur' : 'Utilisateur' }}
                </span>
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   style="color: #e74c3c;">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </nav>
    @endauth

    <div class="container">
        @yield('content')
    </div>
</body>
</html>