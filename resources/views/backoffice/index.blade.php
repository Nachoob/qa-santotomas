<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Backoffice - Index</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <h1>Panel de Control - Backoffice</h1>
    </header>
    <nav>
        <ul>
            <li><a href="#">Inicio</a></li>
            <li><a href="#">Usuarios</a></li>
            <li><a href="#">Configuración</a></li>
        </ul>
    </nav>
    <main>
        <h2>Bienvenido al Backoffice</h2>
        <p>Selecciona una opción del menú para comenzar.</p>
    </main>
    <footer>
        <p>&copy; {{ date('Y') }} Santo Tomás</p>
    </footer>
</body>
</html>