<?php

// Verificar que el archivo se está ejecutando desde el servidor
if (!isset($_SERVER['SERVER_NAME'])) {
    die('Este archivo debe ejecutarse desde el servidor web');
}

// Verificar que es una solicitud local
if (!in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1', '181.161.178.175'])) {
    die('Acceso no autorizado');
}

// Cargar el autoloader de Laravel
require __DIR__.'/../vendor/autoload.php';

// Inicializar la aplicación
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Ejecutar las migraciones
try {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    echo "Migraciones ejecutadas correctamente\n";
    
    // Limpiar cachés
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    echo "Cachés limpiadas correctamente\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Eliminar este archivo después de ejecutarlo
@unlink(__FILE__); 