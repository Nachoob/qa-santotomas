<?php

echo "<pre>";

// 1. Verifica si el archivo existe
$path = __DIR__ . '/app/Http/Middleware/AdminMiddleware.php';
echo "Archivo AdminMiddleware.php: ";
echo file_exists($path) ? "ENCONTRADO\n" : "NO ENCONTRADO\n";

// 2. Intenta cargar la clase usando el autoload de Composer
require __DIR__ . '/vendor/autoload.php';

echo "Clase App\\Http\\Middleware\\AdminMiddleware: ";
if (class_exists('App\Http\Middleware\AdminMiddleware')) {
    echo "ENCONTRADA\n";
    // 3. Instancia la clase y llama al método handle (sin ejecutar lógica)
    try {
        $reflection = new ReflectionClass('App\Http\Middleware\AdminMiddleware');
        echo "Métodos: " . implode(', ', array_map(fn($m) => $m->name, $reflection->getMethods())) . "\n";
    } catch (Exception $e) {
        echo "Error al instanciar: " . $e->getMessage() . "\n";
    }
} else {
    echo "NO ENCONTRADA\n";
}

// 4. Verifica el registro en Kernel.php
$kernelPath = __DIR__ . '/app/Http/Kernel.php';
echo "\nBuscando registro en Kernel.php:\n";
if (file_exists($kernelPath)) {
    $kernelContent = file_get_contents($kernelPath);
    if (strpos($kernelContent, "'admin' => \\App\\Http\\Middleware\\AdminMiddleware::class") !== false) {
        echo "Registro de 'admin' ENCONTRADO en Kernel.php\n";
    } else {
        echo "Registro de 'admin' NO ENCONTRADO en Kernel.php\n";
    }
} else {
    echo "Kernel.php NO ENCONTRADO\n";
}

echo "\nDiagnóstico terminado.\n";
echo "</pre>";