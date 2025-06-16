<?php
// test.php — Colocar en la raíz de tu proyecto Laravel

// Cargamos el autoloader de Composer
require __DIR__ . '/vendor/autoload.php';

// Cargamos la app de Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';

// Obtenemos el Kernel de consola
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Lista de comandos a ejecutar
$commands = [
    'cache:clear',        // Limpia la caché de aplicación
    'config:clear',       // Limpia la caché de configuración
    'route:clear',        // Limpia la caché de rutas
    'view:clear',         // Limpia la caché de vistas
    'config:cache',       // Reconstruye la caché de configuración
    'optimize:clear',     // Limpia todas las optimizaciones (incluye eventos, compilación, etc.)
];

// Ejecutar cada comando y mostrar resultado
echo "<pre>";
foreach ($commands as $cmd) {
    echo "⇢ Ejecutando: php artisan {$cmd}\n";
    $status = $kernel->call($cmd);
    $output = $kernel->output();
    echo trim($output) . "\n\n";
}
// Terminar el ciclo (importante si lo ejecutas en CLI)
$kernel->terminate(
    $kernel->input(),
    0
);
echo "✓ Todas las caches han sido limpiadas y regeneradas.\n";
echo "</pre>";
