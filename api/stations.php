<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/config.php';
$sampleData = require __DIR__ . '/../data/sample_data.php';

$query = strtolower($_GET['q'] ?? '');
$statusFilter = strtolower($_GET['status'] ?? 'all');
$speedFilter = intval($_GET['min_speed'] ?? 0);

$filtered = array_filter($sampleData['charging_stations'], function($stn) use ($query, $statusFilter, $speedFilter) {
    $matchesQuery = empty($query) || strpos(strtolower($stn['name']), $query) !== false || strpos(strtolower($stn['location']), $query) !== false;
    $matchesStatus = ($statusFilter === 'all') || (strtolower($stn['status_code']) === $statusFilter);
    $matchesSpeed = ($stn['charging_speed_kw'] >= $speedFilter);
    return $matchesQuery && $matchesStatus && $matchesSpeed;
});

echo json_encode([
    'status' => 'success',
    'total' => count($filtered),
    'stations' => array_values($filtered)
]);
