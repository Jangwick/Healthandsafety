<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;
use PDO;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController extends BaseController
{
    public function showLogin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_id'])) {
            header('Location: /dashboard');
            exit;
        }

        require_once __DIR__ . '/../../views/pages/login.php';
    }

    public function login(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Please enter both email and password.';
            header('Location: /login');
            exit;
        }

        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT u.*, r.name as role_name, r.hierarchy_level 
            FROM users u 
            JOIN roles r ON u.role_id = r.id 
            WHERE u.email = ? AND u.deleted_at IS NULL
        ");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Check for lockout
            if ($user['lockout_until'] && strtotime($user['lockout_until']) > time()) {
                $waitMinutes = ceil((strtotime($user['lockout_until']) - time()) / 60);
                $_SESSION['error'] = "Account locked due to too many failed attempts. Please try again in $waitMinutes minute(s).";
                header('Location: /login');
                exit;
            }

            if (password_verify($password, $user['password_hash'])) {
                // Success: Reset failed attempts
                $resetStmt = $db->prepare("UPDATE users SET login_attempts = 0, lockout_until = NULL WHERE id = ?");
                $resetStmt->execute([$user['id']]);

                $otp = sprintf("%06d", mt_rand(1, 999999));
                $expiresAt = date('Y-m-d H:i:s', strtotime('+15 minutes'));
                
                $updateStmt = $db->prepare("UPDATE users SET otp_code = ?, otp_expires_at = ? WHERE id = ?");
                $updateStmt->execute([$otp, $expiresAt, $user['id']]);

                $_SESSION['pending_user'] = [
                    'id' => $user['id'],
                    'full_name' => $user['full_name'],
                    'role' => $user['role_name'],
                    'hierarchy' => $user['hierarchy_level']
                ];
                $_SESSION['pending_email'] = $email;
                
                error_log("OTP for $email is $otp");

                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host       = $_ENV['MAIL_HOST'] ?? 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = $_ENV['MAIL_USERNAME'] ?? '';
                    $mail->Password   = $_ENV['MAIL_PASSWORD'] ?? '';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = $_ENV['MAIL_PORT'] ?? 587;

                    $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'] ?? 'noreply@lgu.gov.ph', 'LGU Security');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = 'Your Login OTP';
                    $mail->Body    = "Your OTP for login is: <b>$otp</b><br>It expires in 15 minutes.";
                    $mail->AltBody = "Your OTP for login is: $otp \nIt expires in 15 minutes.";

                    $mail->send();
                    
                    header('Location: /login/otp');
                    exit;
                } catch (Exception $e) {
                    error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
                    $_SESSION['error'] = 'Failed to send OTP email. Mailer Error: ' . $mail->ErrorInfo;
                    header('Location: /login');
                    exit;
                }
            } else {
                // Wrong password: Increment attempts
                $attempts = ($user['login_attempts'] ?? 0) + 1;
                $lockoutUntil = null;

                if ($attempts >= 5) {
                    // Incremental lockout duration
                    $minutes = 5;
                    if ($attempts == 6) $minutes = 15;
                    if ($attempts == 7) $minutes = 30;
                    if ($attempts == 8) $minutes = 60;
                    if ($attempts >= 9) $minutes = 1440; // 24 hours

                    $lockoutUntil = date('Y-m-d H:i:s', strtotime("+$minutes minutes"));
                    $_SESSION['error'] = "Too many failed attempts. Account locked for $minutes minutes.";
                } else {
                    $remaining = 5 - $attempts;
                    $_SESSION['error'] = "Invalid password. $remaining attempts remaining before lockout.";
                }

                $updateStmt = $db->prepare("UPDATE users SET login_attempts = ?, lockout_until = ? WHERE id = ?");
                $updateStmt->execute([$attempts, $lockoutUntil, $user['id']]);
                
                header('Location: /login');
                exit;
            }
        }

        $_SESSION['error'] = 'Invalid email or password.';
        header('Location: /login');
        exit;
    }

    public function showOtp(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_id'])) {
            header('Location: /dashboard');
            exit;
        }

        if (!isset($_SESSION['pending_user'])) {
            header('Location: /login');
            exit;
        }

        require_once __DIR__ . '/../../views/pages/otp.php';
    }

    public function verifyOtp(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['pending_user']) || !isset($_SESSION['pending_email'])) {
            header('Location: /login');
            exit;
        }

        $otp = $_POST['otp'] ?? '';
        $email = $_SESSION['pending_email'];

        if (empty($otp)) {
            $_SESSION['error'] = 'Please enter the OTP.';
            header('Location: /login/otp');
            exit;
        }

        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT id, otp_code, otp_expires_at FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && $user['otp_code'] === $otp && strtotime($user['otp_expires_at']) >= time()) {
            
            // Clear OTP
            $updateStmt = $db->prepare("UPDATE users SET otp_code = NULL, otp_expires_at = NULL WHERE id = ?");
            $updateStmt->execute([$user['id']]);

            $_SESSION['user_id'] = $_SESSION['pending_user']['id'];
            $_SESSION['user'] = $_SESSION['pending_user'];
            
            unset($_SESSION['pending_user']);
            unset($_SESSION['pending_email']);

            header('Location: /dashboard');
            exit;
        }

        $_SESSION['error'] = 'Invalid or expired OTP.';
        header('Location: /login/otp');
        exit;
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        session_destroy();
        header('Location: /login');
        exit;
    }
}
