<?php
/**
 * Vercel Serverless Gateway & Router Entry Point
 */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Handle static assets routing fallback if passed to function
if (strpos($uri, '/assets/') === 0) {
    $assetFile = __DIR__ . '/..' . $uri;
    if (file_exists($assetFile) && !is_dir($assetFile)) {
        $ext = pathinfo($assetFile, PATHINFO_EXTENSION);
        $mimeTypes = [
            'css'  => 'text/css',
            'js'   => 'application/javascript',
            'png'  => 'image/png',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'svg'  => 'image/svg+xml',
            'json' => 'application/json'
        ];
        if (isset($mimeTypes[$ext])) {
            header("Content-Type: " . $mimeTypes[$ext]);
        }
        readfile($assetFile);
        exit;
    }
}

// Map URI to root PHP pages
$requestedPath = ltrim($uri, '/');
if (empty($requestedPath) || $requestedPath === '/') {
    $requestedPath = 'index.php';
}

$targetPhpFile = __DIR__ . '/../' . $requestedPath;

if (file_exists($targetPhpFile) && !is_dir($targetPhpFile) && strripos($targetPhpFile, '.php') !== false) {
    require_once $targetPhpFile;
    exit;
}

// Default fallback to index.php
require_once __DIR__ . '/../index.php';
