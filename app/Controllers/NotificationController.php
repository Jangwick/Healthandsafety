<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Notification;
use App\Middleware\AuthMiddleware;

class NotificationController extends BaseController
{
    private AuthMiddleware $auth;
    private Notification $notificationModel;

    public function __construct()
    {
        $this->auth = new AuthMiddleware();
        $this->notificationModel = new Notification();
    }

    public function index(): void
    {
        $user = $this->auth->handle();
        $notifications = (new Notification())->allForUser($user['id']);
        
        ob_start();
        $this->view('pages/notifications/index', ['notifications' => $notifications]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => 'Notifications - LGU H&S',
            'pageHeading' => 'Notification Intelligence',
            'breadcrumb' => ['Notifications' => '#'],
            'content' => $content
        ]);
    }

    public function getUnread(): void
    {
        $user = $this->auth->handle();
        $notifications = $this->notificationModel->getUnread($user['id']);
        
        header('Content-Type: application/json');
        echo json_encode(['notifications' => $notifications]);
    }

    public function markAsRead(): void
    {
        $user = $this->auth->handle();
        $id = (int)($_GET['id'] ?? 0);
        
        if ($id > 0) {
            $this->notificationModel->markAsRead($id);
        }
        
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    }

    public function markAllAsRead(): void
    {
        $user = $this->auth->handle();
        $this->notificationModel->markAllAsRead($user['id']);
        
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    }
}
