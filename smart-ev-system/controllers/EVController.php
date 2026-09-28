<?php
namespace Controllers;

require_once __DIR__ . '/../models/EV.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../core/Validator.php';

use Models\EV;
use Core\Auth;
use Core\Response;
use Core\Validator;

class EVController {
    private $evModel;

    public function __construct() {
        $this->evModel = new EV();
    }

    public function index() {
        $userId = $_GET['user_id'] ?? ($_SESSION['user']['userId'] ?? 'USR-8829');
        $evs = $this->evModel->getByUserId($userId);
        if (empty($evs)) {
            $evs = $this->evModel->getAll();
        }
        return Response::success($evs, "EV profiles retrieved");
    }

    public function store() {
        $data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $missing = Validator::required($data, ['model', 'batteryCapacity', 'connectorType', 'maxChargingPower']);
        if (!empty($missing)) {
            return Response::error("Missing EV parameters: " . implode(', ', $missing), 422);
        }

        if (!Validator::positiveNumber($data['batteryCapacity'])) {
            return Response::error("Battery capacity must be a positive number", 422);
        }

        $userId = $_SESSION['user']['userId'] ?? ($data['userId'] ?? 'USR-8829');
        $result = $this->evModel->create($userId, $data);
        return Response::success($result, "EV Profile added to Neo4j Graph", 201);
    }

    public function show(string $id) {
        $ev = $this->evModel->findById($id);
        if (!$ev) {
            return Response::error("EV profile not found", 404);
        }
        return Response::success($ev, "EV profile details");
    }

    public function updateBattery(string $id) {
        $data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $soc = floatval($data['currentBattery'] ?? 68);
        if (!Validator::batteryPct($soc)) {
            return Response::error("Battery SOC percentage must be between 0 and 100", 422);
        }

        $updated = $this->evModel->updateBattery($id, $soc);
        return Response::success($updated, "EV Battery SOC updated");
    }

    public function destroy(string $id) {
        $this->evModel->delete($id);
        return Response::success([], "EV Profile removed");
    }
}
