<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;
use App\Middleware\AuthMiddleware;
use PDO;

class UserController extends BaseController
{
    private PDO $db;
    private AuthMiddleware $auth;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->auth = new AuthMiddleware();
    }

    public function index(): void
    {
        $this->auth->handle();
        
        $stmt = $this->db->query("
            SELECT u.*, r.name as role_name 
            FROM users u
            JOIN roles r ON u.role_id = r.id
            ORDER BY u.full_name ASC
        ");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        $this->view('pages/users/list', ['users' => $users]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => 'Users - LGU H&S',
            'pageHeading' => 'User Management',
            'breadcrumb' => ['Users' => '/users'],
            'content' => $content
        ]);
    }
}
