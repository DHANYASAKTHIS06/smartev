<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
$sampleData = require __DIR__ . '/../data/sample_data.php';

$origin = $_GET['origin'] ?? 'Downtown Central Plaza';
$destination = $_GET['destination'] ?? 'Tech Hub East';
$battery = intval($_GET['battery'] ?? 68);
$preference = $_GET['preference'] ?? 'smart';

// Calculate graph paths with energy safety margins
$routes = [
    [
        'id' => 'route_smart',
        'type' => 'SMART RECOMMENDED ROUTE ⭐',
        'is_recommended' => true,
        'distance_km' => 148,
        'travel_time' => '2h 55m',
        'charging_stops' => 1,
        'charging_cost' => 155,
        'battery_safety_pct' => 92,
        'station' => $sampleData['charging_stations'][0],
        'energy_consumed_kwh' => 23.6,
        'cypher_query' => "MATCH (start:Location {name: '$origin'}), (end:Location {name: '$destination'})\nMATCH p = (start)-[:ROAD*..5]->(st:ChargingStation)-[:ROAD*..5]->(end)\nWHERE st.predicted_demand_pct < 70 AND st.charging_speed_kw >= 150\nRETURN p, st ORDER BY st.predicted_demand_pct ASC LIMIT 1;"
    ],
    [
        'id' => 'route_fastest',
        'type' => 'FASTEST ROUTE',
        'is_recommended' => false,
        'distance_km' => 145,
        'travel_time' => '2h 48m',
        'charging_stops' => 1,
        'charging_cost' => 185,
        'battery_safety_pct' => 84,
        'station' => $sampleData['charging_stations'][1],
        'energy_consumed_kwh' => 24.1,
        'cypher_query' => "MATCH (start:Location {name: '$origin'}), (end:Location {name: '$destination'})\nCALL gds.shortestPath.dijkstra.stream({nodeProjection: 'Location', relationshipProjection: 'ROAD', relationshipWeightProperty: 'travelTime'})\nYIELD totalCost, path RETURN path;"
    ],
    [
        'id' => 'route_cheapest',
        'type' => 'CHEAPEST ROUTE',
        'is_recommended' => false,
        'distance_km' => 151,
        'travel_time' => '3h 05m',
        'charging_stops' => 1,
        'charging_cost' => 142,
        'battery_safety_pct' => 88,
        'station' => $sampleData['charging_stations'][4],
        'energy_consumed_kwh' => 22.8,
        'cypher_query' => "MATCH (start:Location {name: '$origin'}), (end:Location {name: '$destination'})\nMATCH p = (start)-[:ROAD*..6]->(st:ChargingStation)-[:ROAD*..6]->(end)\nRETURN p ORDER BY st.price_per_kwh ASC LIMIT 1;"
    ]
];

echo json_encode([
    'status' => 'success',
    'origin' => $origin,
    'destination' => $destination,
    'battery' => $battery,
    'preference' => $preference,
    'routes' => $routes
]);
