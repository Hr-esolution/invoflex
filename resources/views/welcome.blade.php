<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bienvenue sur InvoFlex</title>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

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

        section {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #262626;
            min-height: 100vh;
            overflow: hidden;
        }

        .content {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 30px;
            background: linear-gradient(
                180deg,
                rgba(255, 255, 255, 0.28) 0%,
                rgba(255, 255, 255, 0) 100%
            );
            backdrop-filter: blur(30px);
            border-radius: 20px;
            width: min(900px, 100%);
            box-shadow: 0 0.5px 0 1px rgba(255, 255, 255, 0.23) inset,
                        0 1px 0 0 rgba(255, 255, 255, 0.66) inset,
                        0 4px 16px rgba(0, 0, 0, 0.12);
            z-index: 10;
            padding: 30px;
        }

        .info {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            max-width: 450px;
            padding: 0 20px;
            text-align: center;
        }

        .info p {
            color: #fff;
            font-weight: 500;
            font-size: 1.1rem;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .movie-night {
            background: linear-gradient(225deg, #ff3cac 0%, #784ba0 50%, #2b86c5 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }

        .btn-login, .btn-register {
            display: inline-block;
            padding: 12px 36px;
            margin: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 6px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-login {
            background: rgba(255, 255, 255, 0.95);
            color: #784ba0;
            border: 1px solid rgba(120, 75, 160, 0.3);
        }

        .btn-register {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-register:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        /* SWIPER */
        .swiper {
            width: 250px;
            height: 450px;
            padding: 50px 0;
        }

        .swiper-slide {
            position: relative;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.25);
            border-radius: 12px;
            user-select: none;
            overflow: hidden;
        }

        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, #0f2027, transparent 50%, transparent);
        }

        .overlay span {
            position: absolute;
            top: 12px;
            right: 12px;
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.85rem;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
        }

        .overlay h2 {
            position: absolute;
            bottom: 20px;
            left: 20px;
            color: white;
            font-weight: 500;
            font-size: 1.15rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
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

        /* ... (animations des cercles copiées depuis ton CSS) ... */
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

        /* Mobile */
        @media (max-width: 768px) {
            .content { flex-direction: column; padding: 20px; }
            .swiper { width: 220px; height: 400px; }
            .info { max-width: 100%; }
            .btn-login, .btn-register { width: 100%; max-width: 250px; margin: 8px 0; }
        }
    </style>
</head>
<body>
    <section>
        <div class="content">
            <div class="info">
                <p>
                    Bienvenue sur <span class="movie-night">InvoFlex</span>,<br>
                    le système de facturation flexible, international et personnalisable.
                </p>
                @guest
                    <a href="{{ route('login') }}" class="btn-login">Se connecter</a>
                    <a href="{{ route('register') }}" class="btn-register">S'inscrire</a>
                @else
                    <a href="{{ route('factures.index') }}" class="btn-login">Accéder à mon espace</a>
                @endguest
            </div>

            <div class="swiper">
                <div class="swiper-wrapper">
                    <!-- Tes images Swiper ici -->
                    <div class="swiper-slide">
                        <img src="https://github.com/ecemgo/mini-samples-great-tricks/assets/13468728/b6f5eb64-887c-43b1-aaba-d52a4c59a379" alt="The Queen's Gambit">
                        <div class="overlay">
                            <span>8.5</span>
                            <h2>The Queen's Gambit</h2>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <img src="https://github.com/ecemgo/mini-samples-great-tricks/assets/13468728/e906353b-fde0-4518-9a03-16545c1161bd" alt="Breaking Bad">
                        <div class="overlay">
                            <span>9.5</span>
                            <h2>Breaking Bad</h2>
                        </div>
                    </div>
                    <!-- Ajoute les autres slides si besoin -->
                    <div class="swiper-slide">
                        <img src="https://github.com/ecemgo/mini-samples-great-tricks/assets/13468728/fc21e481-e28a-41a8-9db3-3b62c1ddc17e" alt="Wednesday">
                        <div class="overlay">
                            <span>8.1</span>
                            <h2>Wednesday</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ul class="circles">
            @for($i = 0; $i < 10; $i++)
                <li></li>
            @endfor
        </ul>
    </section>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".swiper", {
            effect: "cards",
            cardsEffect: {
                rotate: true,
                perSlideRotate: 2,
                perSlideOffset: 8,
            },
            grabCursor: true,
            initialSlide: 1,
            speed: 600,
            loop: true,
            mousewheel: {
                invert: false,
            },
        });
    </script>
</body>
</html>