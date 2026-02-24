<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;
use App\Middleware\AuthMiddleware;
use PDO;

class ProfileController extends BaseController {
    private $db;
    protected AuthMiddleware $auth;

    public function __construct() {
        $this->auth = new AuthMiddleware();
        $this->db = Database::getInstance();
    }

    public function index() {
        $user = $this->auth->handle();
        
        $stmt = $this->db->prepare("SELECT id, email, full_name, role_id FROM users WHERE id = ? AND deleted_at IS NULL");
        $stmt->execute([$user['id']]);
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$profile) {
            header('Location: /login');
            exit;
        }

        ob_start();
        $this->view('pages/profile/index', [
            'profile' => $profile
        ]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'content' => $content,
            'pageTitle' => 'My Profile',
            'pageHeading' => 'My Profile',
            'user' => $user
        ]);
    }

    public function update() {
        $user = $this->auth->handle();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullName = trim($_POST['full_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($fullName) || empty($email)) {
                header('Location: /profile?error=Name and Email are required');
                exit;
            }

            // Check if attempting password change
            if (!empty($newPassword)) {
                if ($newPassword !== $confirmPassword) {
                    header('Location: /profile?error=New passwords do not match');
                    exit;
                }

                // Verify current password
                $stmt = $this->db->prepare("SELECT password_hash FROM users WHERE id = ?");
                $stmt->execute([$user['id']]);
                $dbUser = $stmt->fetch();

                if (!$dbUser || !password_verify($currentPassword, $dbUser['password_hash'])) {
                    header('Location: /profile?error=Incorrect current password');
                    exit;
                }

                $hash = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $this->db->prepare("UPDATE users SET full_name = ?, email = ?, password_hash = ? WHERE id = ?");
                $stmt->execute([$fullName, $email, $hash, $user['id']]);
            } else {
                // Update just profile details
                $stmt = $this->db->prepare("UPDATE users SET full_name = ?, email = ? WHERE id = ?");
                $stmt->execute([$fullName, $email, $user['id']]);
            }

            // Update session
            $_SESSION['user']['full_name'] = $fullName;
            $_SESSION['user']['email'] = $email;

            header('Location: /profile?success=Profile updated successfully');
            exit;
        }
    }
}
