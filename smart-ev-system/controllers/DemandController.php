<?php
namespace Controllers;

require_once __DIR__ . '/../services/DemandPredictionService.php';
require_once __DIR__ . '/../core/Response.php';

use Services\DemandPredictionService;
use Core\Response;

class DemandController {
    private $predictionService;

    public function __construct() {
        $this->predictionService = new DemandPredictionService();
    }

    public function predict() {
        $stationId = $_GET['stationId'] ?? ($_POST['stationId'] ?? 'STN-001');
        $forecast = $this->predictionService->predict($stationId);
        return Response::success($forecast, "Predictive charging demand forecast generated");
    }
}
