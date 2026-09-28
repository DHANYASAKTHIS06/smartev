<?php
namespace Controllers;

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../core/Validator.php';

use Models\User;
use Core\Auth;
use Core\Response;
use Core\Validator;

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register() {
        $data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $missing = Validator::required($data, ['name', 'email', 'password']);
        if (!empty($missing)) {
            return Response::error("Missing required fields: " . implode(', ', $missing), 422);
        }

        if (!Validator::email($data['email'])) {
            return Response::error("Invalid email address format", 422);
        }

        $existing = $this->userModel->findByEmail($data['email']);
        if ($existing) {
            return Response::error("An account with this email address already exists", 409);
        }

        $userId = 'USR-' . uniqid();
        $passwordHash = Auth::hashPassword($data['password']);

        $this->userModel->create([
            'userId'       => $userId,
            'name'         => trim($data['name']),
            'email'        => strtolower(trim($data['email'])),
            'phone'        => $data['phone'] ?? '',
            'passwordHash' => $passwordHash,
            'role'         => $data['role'] ?? 'USER'
        ]);

        $createdUser = $this->userModel->findById($userId);
        Auth::login($createdUser);

        return Response::success($createdUser, "Account registered successfully", 201);
    }

    public function login() {
        $data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $missing = Validator::required($data, ['email', 'password']);
        if (!empty($missing)) {
            return Response::error("Missing email or password", 422);
        }

        $user = $this->userModel->findByEmail($data['email']);
        if (!$user || !Auth::verifyPassword($data['password'], $user['passwordHash'])) {
            return Response::error("Invalid email credentials or password", 401);
        }

        Auth::login($user);
        return Response::success($user, "Authentication successful");
    }

    public function logout() {
        Auth::logout();
        return Response::success([], "Successfully logged out");
    }

    public function me() {
        if (!Auth::check()) {
            return Response::error("Unauthenticated", 401);
        }
        return Response::success(Auth::user(), "Active session profile");
    }
}
