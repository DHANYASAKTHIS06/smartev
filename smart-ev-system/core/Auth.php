<?php
namespace Core;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Auth {
    public static function user() {
        return $_SESSION['user'] ?? null;
    }

    public static function check() {
        return isset($_SESSION['user']);
    }

    public static function isAdmin() {
        return isset($_SESSION['user']) && (strtoupper($_SESSION['user']['role'] ?? '') === 'ADMIN');
    }

    public static function login(array $userData) {
        // Clean password hash before storing in session
        unset($userData['passwordHash']);
        $_SESSION['user'] = $userData;
        return true;
    }

    public static function logout() {
        unset($_SESSION['user']);
        session_destroy();
        return true;
    }

    public static function hashPassword(string $password): string {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    public static function verifyPassword(string $password, string $hash): bool {
        return password_verify($password, $hash);
    }
}
