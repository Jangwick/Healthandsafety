<?php

declare(strict_types=1);

spl_autoload_register(function ($class) {
    $prefix = '';
    $base_dir = __DIR__ . '/../';

    if (str_starts_with($class, 'App\\')) {
        $prefix = 'App\\';
        $path = 'app/';
    } elseif (str_starts_with($class, 'Database\\')) {
        $prefix = 'Database\\';
        $path = 'database/';
    } else {
        return;
    }

    $relative_class = substr($class, strlen($prefix));
    $file = $base_dir . $path . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});
