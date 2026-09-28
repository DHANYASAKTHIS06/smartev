<?php
namespace Controllers;

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/Response.php';

use Models\User;
use Core\Auth;
use Core\Response;

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function index() {
        if (!Auth::isAdmin()) {
            return Response::error("Unauthorized admin access", 403);
        }
        $users = $this->userModel->getAll();
        return Response::success($users, "User accounts retrieved");
    }

    public function show(string $id) {
        $user = $this->userModel->findById($id);
        if (!$user) {
            return Response::error("User not found", 404);
        }
        return Response::success($user, "User details retrieved");
    }

    public function update(string $id) {
        $data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $updated = $this->userModel->update($id, $data);
        return Response::success($updated, "User details updated");
    }

    public function destroy(string $id) {
        if (!Auth::isAdmin()) {
            return Response::error("Unauthorized admin access", 403);
        }
        $this->userModel->delete($id);
        return Response::success([], "User account deleted");
    }
}
