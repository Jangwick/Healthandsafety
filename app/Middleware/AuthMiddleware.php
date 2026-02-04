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

    public function handle(): ?array
    {
        $token = $_COOKIE['jwt_token'] ?? $_SERVER['HTTP_AUTHORIZATION'] ?? null;
        
        if ($token && str_starts_with($token, 'Bearer ')) {
            $token = substr($token, 7);
        }

        if (!$token) {
            header('Location: /login');
            exit;
        }

        $decoded = $this->auth->validateToken($token);
        
        if (!$decoded) {
            header('Location: /login');
            exit;
        }

        return $decoded;
    }

    public function authorize(array $user, int $minHierarchy): void
    {
        if (($user['hierarchy'] ?? 0) < $minHierarchy) {
            http_response_code(403);
            die("Forbidden: Insufficient permissions.");
        }
    }
}
