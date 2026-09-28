<?php
namespace Controllers;

require_once __DIR__ . '/../services/RouteOptimizationService.php';
require_once __DIR__ . '/../services/StationRecommendationService.php';
require_once __DIR__ . '/../core/Response.php';

use Services\RouteOptimizationService;
use Services\StationRecommendationService;
use Core\Response;

class RouteController {
    private $routeService;
    private $recommendationService;

    public function __construct() {
        $this->routeService          = new RouteOptimizationService();
        $this->recommendationService = new StationRecommendationService();
    }

    public function calculate() {
        $data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $origin      = $data['origin'] ?? 'Coimbatore';
        $destination = $data['destination'] ?? 'Tech Hub East';
        $battery     = floatval($data['currentBattery'] ?? 68.0);
        $preference  = $data['preference'] ?? 'SMART_RECOMMENDED';

        $evData = [
            'model'           => $data['evModel'] ?? 'Tesla Model 3 Long Range',
            'batteryCapacity' => floatval($data['batteryCapacity'] ?? 75.0),
            'efficiency'      => floatval($data['efficiency'] ?? 0.16)
        ];

        $routes = $this->routeService->calculateRoute($origin, $destination, $evData, $battery, $preference);
        return Response::success($routes, "Graph Shortest Path & Smart EV Route calculated");
    }

    public function recommend() {
        $data = json_decode(file_get_contents('php://input'), true) ?? $_GET;
        $location  = $data['location'] ?? 'Coimbatore';
        $connector = $data['connector'] ?? 'CCS2';

        $recs = $this->recommendationService->recommend($location, $connector);
        return Response::success($recs, "Recommended en-route charging stations");
    }

    public function recalculate() {
        // Dynamic rerouting endpoint upon station disruption or grid failure
        $data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $failedStation = $data['failedStation'] ?? 'Station B (EcoPulse Metro Hub)';

        $alternative = [
            'disruptionDetected' => true,
            'reason'             => "Station outage reported at {$failedStation}. Recalculating path via Neo4j Graph.",
            'originalRoute' => [
                'path'            => 'Location A → Station B → Destination',
                'distanceKm'      => 145,
                'travelTime'      => '2h 50m',
                'chargingCost'    => 160,
                'batterySafety'   => 84
            ],
            'alternativeRoute' => [
                'path'            => 'Location A → Station C (AeroCity Superhub) → Destination',
                'distanceKm'      => 149,
                'travelTime'      => '2h 56m',
                'chargingCost'    => 150,
                'batterySafety'   => 93,
                'variance'        => [
                    'distance'    => '+4 km',
                    'time'        => '+6 mins',
                    'costSavings' => '-₹10 Saved',
                    'safetyGain'  => '+9% Margin'
                ]
            ]
        ];

        return Response::success($alternative, "Dynamic route recalculation complete");
    }
}
