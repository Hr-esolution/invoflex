<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription • InvoFlex</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', system-ui, sans-serif; }
        body {
            background: linear-gradient(135deg, #f0f4ff 0%, #e6eeff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .register-container {
            width: 100%;
            max-width: 460px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .register-header {
            background: #2196f3;
            color: white;
            padding: 28px 24px;
            text-align: center;
        }
        .register-header h1 {
            font-weight: 600;
            font-size: 24px;
            letter-spacing: -0.5px;
        }
        .register-body {
            padding: 32px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2b2d42;
            font-size: 14px;
        }
        .input-with-icon {
            position: relative;
        }
        .input-with-icon i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #7b809a;
        }
        .form-control {
            width: 100%;
            padding: 14px 14px 14px 42px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            outline: none;
            border-color: #2196f3;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.15);
        }
        .btn {
            width: 100%;
            padding: 14px;
            background: #2196f3;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #1e88e5;
        }
        .links {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6c757d;
        }
        .links a {
            color: #2196f3;
            text-decoration: none;
            font-weight: 600;
        }
        .alert {
            padding: 12px;
            background: #ffe9e9;
            color: #d32f2f;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert ul { margin-top: 6px; padding-left: 20px; }
        .alert li { margin-top: 4px; }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1>Créer un compte InvoFlex</h1>
        </div>
        <div class="register-body">
            @if ($errors->any())
                <div class="alert">
                    <strong>Veuillez corriger les erreurs suivantes :</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Nom complet</label>
                    <div class="input-with-icon">
                        <i class="fas fa-signature"></i>
                        <input 
                            type="text" 
                            name="name" 
                            id="name"
                            value="{{ old('name') }}" 
                            class="form-control"
                            placeholder="ex: Jean Dupont"
                            required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input 
                            type="email" 
                            name="email" 
                            id="email"
                            value="{{ old('email') }}" 
                            class="form-control"
                            placeholder="vous@email.com"
                            required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">Numéro de téléphone</label>
                    <div class="input-with-icon">
                        <i class="fas fa-phone"></i>
                        <input 
                            type="text" 
                            name="phone" 
                            id="phone"
                            value="{{ old('phone') }}" 
                            class="form-control"
                            placeholder="ex: 0612345678"
                            required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            class="form-control"
                            placeholder="••••••••"
                            required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmer le mot de passe</label>
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation"
                            class="form-control"
                            placeholder="••••••••"
                            required
                        >
                    </div>
                </div>

                <button type="submit" class="btn">Créer mon compte</button>

                <div class="links">
                    Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>