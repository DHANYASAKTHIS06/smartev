<?php
namespace Core;

class Response {
    public static function json($data, int $statusCode = 200) {
        // Set CORS headers for Render backend to Vercel frontend deployment
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
        header("Content-Type: application/json; charset=UTF-8");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        http_response_code($statusCode);
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }

    public static function success($data = [], string $message = "Operation successful", int $statusCode = 200) {
        return self::json([
            'success' => true,
            'message' => $message,
            'data'    => $data
        ], $statusCode);
    }

    public static function error(string $message = "Operation failed", int $statusCode = 400, $errorDetails = null) {
        $res = [
            'success' => false,
            'message' => $message
        ];
        if ($errorDetails !== null) {
            $res['error'] = $errorDetails;
        }
        return self::json($res, $statusCode);
    }
}
