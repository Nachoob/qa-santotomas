<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistema de verificación de certificados')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        }
        .logo {
            position: absolute;
            top: 20px;
            left: 40px;
            height: 60px;
            width: auto;
        }
        .menu {
            position: absolute;
            top: 40px;
            left: 130px;
        }
        @media (max-width: 768px) {
            .curved-header { width: 100%; border-radius: 0 0 40px 40px; }
            .logo { left: 16px; top: 16px; height: 40px; }
            .menu { left: 80px; top: 30px; }
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
                <li class="nav-item"><a class="nav-link" href="/certificates">Certificados</a></li>
                <li class="nav-item"><a class="nav-link" href="/verify/">Verificar</a></li>
                @guest
                    <li class="nav-item"><a class="nav-link" href="/login">Acceder</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="/dashboard">Panel</a></li>
                @endguest
            </ul>
        </nav>
    </header>
    <main class="container mt-5 pt-5">
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html> 