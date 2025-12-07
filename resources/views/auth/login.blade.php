<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion • InvoFlex</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', system-ui, sans-serif; }
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-container {
            width: 100%;
            max-width: 420px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .login-header {
            background: #4361ee;
            color: white;
            padding: 28px 24px;
            text-align: center;
        }
        .login-header h1 {
            font-weight: 600;
            font-size: 24px;
            letter-spacing: -0.5px;
        }
        .login-body {
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
            border-color: #4361ee;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }
        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
            font-size: 14px;
        }
        .btn {
            width: 100%;
            padding: 14px;
            background: #4361ee;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #3a56e4;
        }
        .links {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6c757d;
        }
        .links a {
            color: #4361ee;
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
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Connexion à InvoFlex</h1>
        </div>
        <div class="login-body">
            @if ($errors->any())
                <div class="alert">
                    {{ $errors->first('identity') ?: 'Veuillez vérifier vos identifiants.' }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="identity">Email ou Téléphone</label>
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input 
                            type="text" 
                            name="identity" 
                            id="identity"
                            value="{{ old('identity') }}" 
                            class="form-control"
                            placeholder="ex: vous@email.com ou 0612345678"
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

                <div class="form-check">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Se souvenir de moi</label>
                </div>

                <button type="submit" class="btn">Se connecter</button>

                <div class="links">
                    Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>