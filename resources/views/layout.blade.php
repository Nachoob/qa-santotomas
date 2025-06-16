<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistema de Verificación de Certificados')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .curved-header {
            position: relative;
            background: #fff;
            height: 120px;
            width: 70%;
            margin: 0 auto;
            border-bottom-left-radius: 60px 40px;
            border-bottom-right-radius: 60px 40px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.06);
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 0 24px;
        }
        .logo {
            height: 60px;
            border-radius: 50%;
            width: auto;
            margin-right: 32px;
        }
        .menu {
            flex: 1;
        }
        .hamburger {
            display: none;
            margin-left: auto;
            width: 40px;
            height: 40px;
            background: none;
            border: none;
            z-index: 20;
        }
        .hamburger span {
            display: block;
            width: 28px;
            height: 4px;
            margin: 6px auto;
            background: #333;
            border-radius: 2px;
            transition: 0.3s;
        }
        .mobile-menu {
            display: none;
            position: fixed;
            top: 0;
            right: 0;
            width: 220px;
            height: 100vh;
            background: #fff;
            box-shadow: -2px 0 16px rgba(0,0,0,0.08);
            z-index: 100;
            padding: 60px 20px 20px 20px;
            opacity: 0;
            transform: translateX(100%);
            transition: opacity 0.3s, transform 0.3s;
        }
        .mobile-menu.active {
            display: block;
            opacity: 1;
            transform: translateX(0);
        }
        .mobile-menu .nav-link {
            display: block;
            margin-bottom: 18px;
            font-size: 1.1rem;
        }
        .hamburger.active span:nth-child(1) {
            transform: translateY(10px) rotate(45deg);
        }
        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }
        .hamburger.active span:nth-child(3) {
            transform: translateY(-10px) rotate(-45deg);
        }
        @media (max-width: 768px) {
            .curved-header {
                width: 100%;
                border-radius: 0 0 40px 40px;
                height: 72px;
                padding: 0 12px;
            }
            .logo {
                height: 50px;
                margin-right: 18px;
            }
            .menu { display: none; }
            .hamburger { display: block; }
        }
    </style>
    @yield('head')
</head>
<body class="bg-light">
    <header class="curved-header mt-3">
        <a href="/">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="logo">
        </a>
        <nav class="menu">
            <ul class="nav">
                <li class="nav-item"><a class="nav-link" href="/">Inicio</a></li>
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ route('certificates.create') }}">Generar Certificado</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('certificates.verify.form') }}">Validar Certificado</a></li>
                    <li class="nav-item"><a class="nav-link" href="/certificates">Mis Certificados</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
                @endauth
            </ul>
        </nav>
        <button class="hamburger" id="hamburgerBtn" aria-label="Abrir menú">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <nav class="mobile-menu" id="mobileMenu">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="/">Inicio</a></li>
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ route('certificates.create') }}">Generar Certificado</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('certificates.verify.form') }}">Validar Certificado</a></li>
                    <li class="nav-item"><a class="nav-link" href="/certificates">Mis Certificados</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
                @endauth
            </ul>
        </nav>
    </header>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <main class="container mt-5 pt-5">
        @yield('content')
    </main>
    <script>
        // Menú hamburguesa para mobile
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        hamburgerBtn?.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
            hamburgerBtn.classList.toggle('active');
        });
        // Cerrar menú al hacer click fuera
        document.addEventListener('click', function(e) {
            if (mobileMenu.classList.contains('active') && !mobileMenu.contains(e.target) && e.target !== hamburgerBtn) {
                mobileMenu.classList.remove('active');
                hamburgerBtn.classList.remove('active');
            }
        });
    </script>
    @yield('scripts')
</body>
</html> 