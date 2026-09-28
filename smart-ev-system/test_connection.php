<?php
/**
 * Neo4j AuraDB Connection Diagnostic Test Script
 */
header("Content-Type: text/plain; charset=UTF-8");

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/core/Neo4jConnection.php';

use Core\Neo4jConnection;

echo "==================================================\n";
echo "   SMART EV CHARGING NETWORK - NEO4J DIAGNOSTIC   \n";
echo "==================================================\n\n";

try {
    $db = Neo4jConnection::getInstance();
    $result = $db->runQuery("RETURN 1 AS test;");

    if (!empty($result) && isset($result[0]['test']) && $result[0]['test'] == 1) {
        echo "Neo4j Connection: SUCCESS\n";
        echo "Database: Connected\n";
        echo "AuraDB Target: " . getenv('NEO4J_URI') . "\n";
        echo "Status: READY FOR QUERY OPERATIONS\n";
    } else {
        echo "Neo4j Connection: FAILED\n";
        echo "Reason: Unexpected query result output\n";
    }
} catch (\Exception $e) {
    echo "Neo4j Connection: FAILED\n";
    echo "Error Message: " . $e->getMessage() . "\n";
}
