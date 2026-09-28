<?php
/**
 * Smart EV Charging Network Backend Gateway (Public Entry Point)
 * Prepared for Render deployment & local PHP server
 */

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../core/Response.php';

use Core\Response;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Handle preflight OPTIONS requests for CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    Response::json([], 200);
}

// Route API requests
if (strpos($uri, '/api/auth') === 0) {
    require_once __DIR__ . '/../controllers/AuthController.php';
    $ctrl = new \Controllers\AuthController();
    if (strpos($uri, '/register') !== false) $ctrl->register();
    elseif (strpos($uri, '/login') !== false) $ctrl->login();
    elseif (strpos($uri, '/logout') !== false) $ctrl->logout();
    else $ctrl->me();
    exit;
}

if (strpos($uri, '/api/users') === 0) {
    require_once __DIR__ . '/../controllers/UserController.php';
    $ctrl = new \Controllers\UserController();
    $id = basename($uri);
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && $id !== 'users') $ctrl->show($id);
    elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') $ctrl->update($id);
    elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') $ctrl->destroy($id);
    else $ctrl->index();
    exit;
}

if (strpos($uri, '/api/ev') === 0) {
    require_once __DIR__ . '/../controllers/EVController.php';
    $ctrl = new \Controllers\EVController();
    $id = basename($uri);
    if (strpos($uri, '/battery') !== false) {
        $parts = explode('/', trim($uri, '/'));
        $ctrl->updateBattery($parts[2] ?? '');
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') $ctrl->store();
    elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $id !== 'ev') $ctrl->show($id);
    elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') $ctrl->destroy($id);
    else $ctrl->index();
    exit;
}

if (strpos($uri, '/api/routes') === 0) {
    require_once __DIR__ . '/../controllers/RouteController.php';
    $ctrl = new \Controllers\RouteController();
    if (strpos($uri, '/recommend') !== false) $ctrl->recommend();
    elseif (strpos($uri, '/recalculate') !== false) $ctrl->recalculate();
    else $ctrl->calculate();
    exit;
}

if (strpos($uri, '/api/stations') === 0) {
    require_once __DIR__ . '/../controllers/StationController.php';
    $ctrl = new \Controllers\StationController();
    $id = basename($uri);
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && $id !== 'stations') $ctrl->show($id);
    elseif ($_SERVER['REQUEST_METHOD'] === 'POST') $ctrl->store();
    elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') $ctrl->update($id);
    elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') $ctrl->destroy($id);
    else $ctrl->index();
    exit;
}

if (strpos($uri, '/api/charging') === 0) {
    require_once __DIR__ . '/../controllers/ChargingController.php';
    $ctrl = new \Controllers\ChargingController();
    if (strpos($uri, '/end') !== false) $ctrl->endSession();
    else $ctrl->startSession();
    exit;
}

if (strpos($uri, '/api/demand') === 0) {
    require_once __DIR__ . '/../controllers/DemandController.php';
    $ctrl = new \Controllers\DemandController();
    $ctrl->predict();
    exit;
}

if (strpos($uri, '/api/trips') === 0) {
    require_once __DIR__ . '/../controllers/TripController.php';
    $ctrl = new \Controllers\TripController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') $ctrl->store();
    else $ctrl->index();
    exit;
}

if (strpos($uri, '/api/notifications') === 0) {
    require_once __DIR__ . '/../controllers/NotificationController.php';
    $ctrl = new \Controllers\NotificationController();
    if (strpos($uri, '/read') !== false) {
        $parts = explode('/', trim($uri, '/'));
        $ctrl->markRead($parts[2] ?? '');
    } else $ctrl->index();
    exit;
}

if (strpos($uri, '/api/admin') === 0) {
    require_once __DIR__ . '/../controllers/AdminController.php';
    $ctrl = new \Controllers\AdminController();
    if (strpos($uri, '/graph') !== false) $ctrl->graphTopology();
    else $ctrl->dashboardStats();
    exit;
}

if (strpos($uri, '/api/graph') === 0) {
    require_once __DIR__ . '/../controllers/AdminController.php';
    $ctrl = new \Controllers\AdminController();
    $ctrl->graphTopology();
    exit;
}

// Default Health Route
require_once __DIR__ . '/../health.php';
