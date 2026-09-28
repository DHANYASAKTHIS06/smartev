<?php
namespace Controllers;

require_once __DIR__ . '/../models/Notification.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/Response.php';

use Models\Notification;
use Core\Auth;
use Core\Response;

class NotificationController {
    private $notifModel;

    public function __construct() {
        $this->notifModel = new Notification();
    }

    public function index() {
        $userId = $_SESSION['user']['userId'] ?? 'USR-8829';
        $notifs = $this->notifModel->getByUserId($userId);
        return Response::success($notifs, "User notifications retrieved");
    }

    public function markRead(string $id) {
        $this->notifModel->markAsRead($id);
        return Response::success([], "Notification marked as read");
    }
}
