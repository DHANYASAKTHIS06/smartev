<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/config.php';
$sampleData = require __DIR__ . '/../data/sample_data.php';

$stationId = $_GET['station_id'] ?? 'STN-001';

echo json_encode([
    'status' => 'success',
    'station_id' => $stationId,
    'station_name' => $sampleData['charging_stations'][0]['name'],
    'current_demand_pct' => 42,
    'predicted_peak_time' => '6:00 PM - 7:00 PM',
    'recommendation' => 'Demand is expected to increase significantly between 6 PM and 7 PM. Consider charging before 5:30 PM.',
    'forecast' => $sampleData['demand_forecast']
]);
