<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Services\AuthService;

class AuthMiddleware
{
    private AuthService $auth;

    public function __construct()
    {
        $this->auth = new AuthService();
    }

    public function handle(): array
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        return $_SESSION['user'] ?? [
            'id' => $_SESSION['user_id'],
            'full_name' => 'User',
            'role' => 'Inspector',
            'hierarchy' => 5
        ];
    }

    public function authorize(array $user, int $minHierarchy): void
    {
        if (($user['hierarchy'] ?? 0) < $minHierarchy) {
            http_response_code(403);
            die("Forbidden: Insufficient permissions.");
        }
    }
}
