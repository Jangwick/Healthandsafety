<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class AuthService
{
    private User $userModel;
    private string $secret;
    private int $expiry;

    public function __construct()
    {
        $this->userModel = new User();
        $this->secret = $_ENV['JWT_SECRET'] ?? 'default_secret';
        $this->expiry = (int) ($_ENV['JWT_EXPIRY'] ?? 3600);
    }

    public function login(string $email, string $password): ?string
    {
        $user = $this->userModel->findByEmail($email);
        
        if (!$user || !password_verify($password, $user['password_hash'])) {
            return null;
        }

        $payload = [
            'iss' => $_ENV['APP_URL'] ?? 'http://localhost',
            'iat' => time(),
            'exp' => time() + $this->expiry,
            'sub' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role_name'],
            'hierarchy' => $user['hierarchy_level']
        ];

        return JWT::encode($payload, $this->secret, 'HS256');
    }

    public function validateToken(string $token): ?array
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secret, 'HS256'));
            return (array) $decoded;
        } catch (Exception $e) {
            return null;
        }
    }
}
