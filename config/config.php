<?php
/**
 * Smart EV Charging Network Route Optimization and Predictive Demand Management
 * Global Configuration File
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('APP_NAME', 'Smart EV RouteOpt Neo4j');
define('APP_TITLE', 'Smart EV Charging Network Route Optimization & Predictive Demand Management');
define('APP_VERSION', '1.0.0');
define('BASE_URL', '/');
define('BACKEND_API_URL', 'https://smartev-1.onrender.com');

// Default user state for demo if not set
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = [
        'id' => 'USR-8829',
        'name' => 'Alex Rivera',
        'email' => 'alex.rivera@evmobility.io',
        'role' => 'user',
        'ev_model' => 'Tesla Model 3 Long Range',
        'battery_capacity' => 75, // kWh
        'current_battery' => 68,  // %
        'connector_type' => 'CCS2 / Type 2',
        'max_charging_power' => 250, // kW
        'efficiency' => 0.160, // kWh/km
        'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=250'
    ];
}

// Flash notification helper
function set_flash_message($type, $message) {
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

function get_flash_message() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

// Active link helper for navigation
function is_active_page($page_name) {
    $current = basename($_SERVER['PHP_SELF']);
    return ($current === $page_name) ? 'active' : '';
}
