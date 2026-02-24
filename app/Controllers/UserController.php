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

    public function create(): void
    {
        $this->auth->handle();
        
        $roles = $this->db->query("SELECT * FROM roles ORDER BY hierarchy_level DESC")->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        $this->view('pages/users/create', ['roles' => $roles]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => 'Add User - LGU H&S',
            'pageHeading' => 'Register New User',
            'breadcrumb' => ['Users' => '/users', 'Add' => '#'],
            'content' => $content
        ]);
    }

    public function store(): void
    {
        $this->auth->handle();

        $fullName = $_POST['full_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $roleId = (int)($_POST['role_id'] ?? 0);

        if (empty($fullName) || empty($email) || empty($password) || $roleId <= 0) {
            header('Location: /users/create?error=Please fill all fields');
            exit;
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        try {
            $stmt = $this->db->prepare("INSERT INTO users (full_name, email, password_hash, role_id) VALUES (?, ?, ?, ?)");
            $stmt->execute([$fullName, $email, $passwordHash, $roleId]);
            $newId = (int)$this->db->lastInsertId();
            $this->logTransaction('CREATE', 'users', $newId, ['full_name' => $fullName, 'email' => $email, 'role_id' => $roleId]);
            header('Location: /users?success=User added successfully');
        } catch (\PDOException $e) {
            header('Location: /users/create?error=Email already registered');
        }
        exit;
    }

    public function delete(): void
    {
        $this->auth->handle();
        $id = (int)($_GET['id'] ?? 0);

        if ($id <= 0) {
            header('Location: /users?error=Invalid user ID');
            exit;
        }

        // Prevent self-deletion
        if ($id === ($_SESSION['user']['id'] ?? 0)) {
            header('Location: /users?error=You cannot delete your own account');
            exit;
        }

        try {
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $this->logTransaction('DELETE', 'users', $id, ['user_id' => $id]);
            header('Location: /users?success=User deleted successfully');
        } catch (\PDOException $e) {
            header('Location: /users?error=Unable to delete user (may have related records)');
        }
        exit;
    }

    public function edit(): void
    {
        $this->auth->handle();
        $id = (int)($_GET['id'] ?? 0);
        
        $user = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $user->execute([$id]);
        $userData = $user->fetch(PDO::FETCH_ASSOC);

        if (!$userData) {
            header('Location: /users?error=User not found');
            exit;
        }

        $roles = $this->db->query("SELECT * FROM roles ORDER BY hierarchy_level DESC")->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        $this->view('pages/users/edit', ['user' => $userData, 'roles' => $roles]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => 'Edit User - LGU H&S',
            'pageHeading' => 'Update User Details',
            'breadcrumb' => ['Users' => '/users', 'Edit' => '#'],
            'content' => $content
        ]);
    }

    public function update(): void
    {
        $this->auth->handle();
        $id = (int)($_POST['id'] ?? 0);
        $fullName = $_POST['full_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $roleId = (int)($_POST['role_id'] ?? 0);
        $password = $_POST['password'] ?? '';

        if (empty($fullName) || empty($email) || $roleId <= 0) {
            header('Location: /users/edit?id=' . $id . '&error=Please fill all required fields');
            exit;
        }

        try {
            if (!empty($password)) {
                $passwordHash = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $this->db->prepare("UPDATE users SET full_name = ?, email = ?, role_id = ?, password_hash = ? WHERE id = ?");
                $stmt->execute([$fullName, $email, $roleId, $passwordHash, $id]);
                $this->logTransaction('UPDATE', 'users', $id, ['full_name' => $fullName, 'email' => $email, 'role_id' => $roleId, 'password_updated' => true]);
            } else {
                $stmt = $this->db->prepare("UPDATE users SET full_name = ?, email = ?, role_id = ? WHERE id = ?");
                $stmt->execute([$fullName, $email, $roleId, $id]);
                $this->logTransaction('UPDATE', 'users', $id, ['full_name' => $fullName, 'email' => $email, 'role_id' => $roleId]);
            }
            header('Location: /users?success=User updated successfully');
        } catch (\PDOException $e) {
            header('Location: /users/edit?id=' . $id . '&error=Email already registered');
        }
        exit;
    }
}
