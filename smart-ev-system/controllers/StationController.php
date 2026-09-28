<?php
namespace Controllers;

require_once __DIR__ . '/../models/ChargingStation.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/Response.php';

use Models\ChargingStation;
use Core\Auth;
use Core\Response;

class StationController {
    private $stationModel;

    public function __construct() {
        $this->stationModel = new ChargingStation();
    }

    public function index() {
        $query  = strtolower($_GET['q'] ?? '');
        $status = strtolower($_GET['status'] ?? 'all');
        $all = $this->stationModel->getAll();

        if (!empty($query) || $status !== 'all') {
            $all = array_values(array_filter($all, function($s) use ($query, $status) {
                $matchQ = empty($query) || strpos(strtolower($s['name']), $query) !== false || strpos(strtolower($s['locationName'] ?? ''), $query) !== false;
                $matchS = ($status === 'all') || (strtolower($s['operatingStatus']) === $status);
                return $matchQ && $matchS;
            }));
        }

        return Response::success($all, "Charging stations directory retrieved");
    }

    public function show(string $id) {
        $station = $this->stationModel->findById($id);
        if (!$station) {
            return Response::error("Charging station not found", 404);
        }
        return Response::success($station, "Station details retrieved");
    }

    public function store() {
        if (!Auth::isAdmin()) {
            return Response::error("Admin privileges required", 403);
        }
        $data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $created = $this->stationModel->create($data, $data['locationName'] ?? 'Coimbatore');
        return Response::success($created, "Charging station added to Neo4j Graph", 201);
    }

    public function update(string $id) {
        if (!Auth::isAdmin()) {
            return Response::error("Admin privileges required", 403);
        }
        $data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $updated = $this->stationModel->updateStatus($id, $data['operatingStatus'] ?? 'AVAILABLE', intval($data['availableChargers'] ?? 4));
        return Response::success($updated, "Charging station details updated");
    }

    public function destroy(string $id) {
        if (!Auth::isAdmin()) {
            return Response::error("Admin privileges required", 403);
        }
        return Response::success([], "Charging station disabled");
    }
}
