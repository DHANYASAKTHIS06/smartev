<?php
namespace Controllers;

require_once __DIR__ . '/../models/ChargingSession.php';
require_once __DIR__ . '/../core/Response.php';

use Models\ChargingSession;
use Core\Response;

class ChargingController {
    private $sessionModel;

    public function __construct() {
        $this->sessionModel = new ChargingSession();
    }

    public function startSession() {
        $data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $evId      = $data['evId'] ?? 'EV-101';
        $stationId = $data['stationId'] ?? 'STN-001';

        $sessionData = [
            'sessionId'      => 'SESS-' . uniqid(),
            'startTime'      => date('Y-m-d H:i:s'),
            'status'         => 'ACTIVE',
            'energyConsumed' => 0.0,
            'chargingCost'   => 0.0,
            'duration'       => 0
        ];

        $res = $this->sessionModel->create($evId, $stationId, $sessionData);
        return Response::success($res, "Charging session initialized at station", 201);
    }

    public function endSession() {
        $data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $sessionId = $data['sessionId'] ?? 'SESS-001';

        $completedData = [
            'sessionId'      => $sessionId,
            'endTime'        => date('Y-m-d H:i:s'),
            'status'         => 'COMPLETED',
            'energyConsumed' => floatval($data['energyConsumed'] ?? 34.5),
            'chargingCost'   => floatval($data['chargingCost'] ?? 240.0),
            'duration'       => intval($data['duration'] ?? 22)
        ];

        return Response::success($completedData, "Charging session finalized successfully");
    }
}
