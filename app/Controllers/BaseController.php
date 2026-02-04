<?php

declare(strict_types=1);

namespace App\Controllers;

abstract class BaseController
{
    protected function json(mixed $data, int $status = 200): void
    {
        http_response_code($status);
        echo json_encode($data);
        exit;
    }

    protected function view(string $path, array $data = []): void
    {
        extract($data);
        $fullPath = __DIR__ . "/../../views/{$path}.php";
        
        if (file_exists($fullPath)) {
            require_once $fullPath;
        } else {
            die("View not found: {$path}");
        }
    }
}
