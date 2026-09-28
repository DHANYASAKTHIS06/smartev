<?php
/**
 * System Health Status API Endpoint
 */
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/core/Neo4jConnection.php';

use Core\Neo4jConnection;

$neo4jStatus = "UNKNOWN";
$dbAvailable = false;
$errorMsg    = null;

try {
    $db = Neo4jConnection::getInstance();
    $res = $db->runQuery("RETURN 1 AS ping;");
    if (!empty($res) && $res[0]['ping'] == 1) {
        $neo4jStatus = "CONNECTED";
        $dbAvailable = true;
    }
} catch (\Exception $e) {
    $neo4jStatus = "DISCONNECTED";
    $errorMsg    = $e->getMessage();
}

$health = [
    'status'       => $dbAvailable ? 'OK' : 'DEGRADED',
    'timestamp'    => date('c'),
    'php_version'  => PHP_VERSION,
    'server_os'    => PHP_OS_FAMILY,
    'neo4j'        => [
        'uri'         => getenv('NEO4J_URI') ?: 'neo4j+s://355200dd.databases.neo4j.io',
        'status'      => $neo4jStatus,
        'available'   => $dbAvailable
    ]
];

if ($errorMsg) {
    $health['neo4j']['error'] = $errorMsg;
}

http_response_code($dbAvailable ? 200 : 503);
echo json_encode($health, JSON_PRETTY_PRINT);
