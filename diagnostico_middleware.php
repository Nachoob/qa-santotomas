<?php

header('Content-Type: text/plain; charset=utf-8');

function showFile($path) {
    echo "\n==== $path ====";
    if (file_exists($path)) {
        echo "\n" . file_get_contents($path) . "\n";
    } else {
        echo "\n(No existe)\n";
    }
}

// Mostrar archivos clave de caché y autoload
showFile(__DIR__ . '/bootstrap/cache/config.php');
showFile(__DIR__ . '/bootstrap/cache/routes-v7.php');
showFile(__DIR__ . '/bootstrap/cache/routes.php');
showFile(__DIR__ . '/vendor/composer/autoload_classmap.php');
showFile(__DIR__ . '/vendor/composer/autoload_psr4.php');
showFile(__DIR__ . '/app/Http/Kernel.php');
showFile(__DIR__ . '/app/Http/Middleware/AdminMiddleware.php');

// Mostrar últimos logs
$logDir = __DIR__ . '/storage/logs/';
if (is_dir($logDir)) {
    $logs = glob($logDir . '*.log');
    rsort($logs);
    foreach (array_slice($logs, 0, 2) as $log) {
        showFile($log);
    }
}

echo "\n\nFIN DEL DIAGNÓSTICO\n";