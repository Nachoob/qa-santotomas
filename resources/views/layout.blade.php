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
                <li class="nav-item"><a class="nav-link" href="/">{{ __('messages.welcome') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="/certificates">{{ __('messages.certificates_list') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('certificates.verify.form') }}">{{ __('messages.verify_certificate') }}</a></li>
                @auth
                    @if(auth()->user()->is_admin)
                        <li class="nav-item"><a class="nav-link" href="/admin">{{ __('messages.admin_panel') }}</a></li>
                    @endif
                    <li class="nav-item"><a class="nav-link" href="/logout">{{ __('messages.logout') }}</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="/login">{{ __('messages.login') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="/register">{{ __('messages.register') }}</a></li>
                @endauth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="langDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ __('messages.language') }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="langDropdown">
                        <li><a class="dropdown-item" href="?lang=es">{{ __('messages.spanish') }}</a></li>
                        <li><a class="dropdown-item" href="?lang=en">{{ __('messages.english') }}</a></li>
                    </ul>
                </li>
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