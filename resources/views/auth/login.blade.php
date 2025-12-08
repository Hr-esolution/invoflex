<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion • InvoFlex</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700;800&display=swap");

        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Comfortaa", cursive;
        }

        body {
            background: #262626;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-container {
            background: linear-gradient(180deg, rgba(255,255,255,0.25) 0%, rgba(255,255,255,0) 100%);
            backdrop-filter: blur(25px);
            border-radius: 20px;
            padding: 40px;
            width: min(900px, 100%);
            max-width: 500px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            position: relative;
            z-index: 10;
        }

        .logo {
            text-align: center;
            margin-bottom: 24px;
        }

        .logo h1 {
            font-size: 28px;
            color: white;
            background: linear-gradient(225deg, #ff3cac, #784ba0, #2b86c5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            color: #fff;
            font-size: 15px;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            width: 100%;
            padding: 14px;
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            background: rgba(255,255,255,0.1);
            color: white;
            font-size: 16px;
        }

        .form-control::placeholder {
            color: rgba(255,255,255,0.6);
        }

        .btn-login {
            display: block;
            width: 100%;
            padding: 14px;
            background: linear-gradient(225deg, #ff3cac, #784ba0);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: transform 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-3px);
        }

        .links {
            text-align: center;
            margin-top: 20px;
            color: #aaa;
        }

        .links a {
            color: #784ba0;
            text-decoration: none;
            font-weight: 600;
            margin-left: 8px;
        }

        .alert {
            background: rgba(255, 100, 100, 0.2);
            color: #ffcccc;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        /* Animated background */
        .circles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .circles li {
            position: absolute;
            width: 20px;
            height: 20px;
            background: linear-gradient(225deg, #ff3cac, #784ba0, #2b86c5);
            border-radius: 50%;
            animation: animate 25s infinite linear;
            bottom: -150px;
        }

        .circles li:nth-child(1) { left: 25%; width: 80px; height: 80px; }
        .circles li:nth-child(2) { left: 10%; width: 20px; height: 20px; animation-duration: 12s; animation-delay: 2s; }
        .circles li:nth-child(3) { left: 70%; width: 20px; height: 20px; animation-delay: 4s; }
        .circles li:nth-child(4) { left: 40%; width: 60px; height: 60px; animation-duration: 18s; }
        .circles li:nth-child(5) { left: 65%; width: 20px; height: 20px; }
        .circles li:nth-child(6) { left: 75%; width: 110px; height: 110px; animation-delay: 3s; }
        .circles li:nth-child(7) { left: 35%; width: 150px; height: 150px; animation-delay: 7s; }
        .circles li:nth-child(8) { left: 50%; width: 25px; height: 25px; animation-duration: 45s; animation-delay: 15s; }
        .circles li:nth-child(9) { left: 20%; width: 15px; height: 15px; animation-duration: 35s; animation-delay: 2s; }
        .circles li:nth-child(10) { left: 85%; width: 150px; height: 150px; animation-duration: 11s; }

        @keyframes animate {
            0% { transform: translateY(0) rotate(0deg); opacity: 1; }
            100% { transform: translateY(-1000px) rotate(720deg); opacity: 0; }
        }

        @media (max-width: 600px) {
            .login-container {
                padding: 30px 20px;
                margin: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h1>Connexion à InvoFlex</h1>
        </div>

        @if ($errors->any())
            <div class="alert">
                {{ $errors->first('identity') ?: 'Identifiants invalides.' }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label>Email ou Téléphone</label>
                <input type="text" name="identity" value="{{ old('identity') }}" class="form-control" placeholder="ex: vous@email.com ou 0612345678" required>
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </button>
        </form>

        <div class="links">
            Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a>
        </div>
    </div>

    <ul class="circles">
        @for($i = 0; $i < 10; $i++)
            <li></li>
        @endfor
    </ul>
</body>
</html>