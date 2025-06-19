<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: #f8f9fa; /* Light background */
            }
            .auth-card {
                width: 100%;
                max-width: 400px;
                margin-top: 6rem; /* Adjust for curved header */
                padding: 1.5rem;
                background-color: #ffffff;
                border-radius: 0.5rem;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            }
            .application-logo {
                margin-bottom: 1.5rem;
                text-align: center;
            }
            .application-logo a {
                font-size: 1.5rem;
                font-weight: bold;
                color: #333;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class="container d-flex flex-column align-items-center">
            <div class="auth-card">
                <div class="application-logo">
                    <a href="/">
                        <!-- Asegúrate de tener logo.png en public/ -->
                        <img src="{{ asset('logo.png') }}" alt="Logo" style="width: 80px; height: 80px;">
                    </a>
                </div>
                @yield('content')
            </div>
        </div>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        @yield('scripts')
        @yield('footer')
    </body>
</html>
