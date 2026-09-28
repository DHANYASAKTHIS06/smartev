<?php
namespace Controllers;

require_once __DIR__ . '/../models/Trip.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/Response.php';

use Models\Trip;
use Core\Auth;
use Core\Response;

class TripController {
    private $tripModel;

    public function __construct() {
        $this->tripModel = new Trip();
    }

    public function index() {
        $userId = $_SESSION['user']['userId'] ?? ($_GET['userId'] ?? 'USR-8829');
        $trips = $this->tripModel->getByUserId($userId);
        if (empty($trips)) {
            $trips = $this->tripModel->getAll();
        }
        return Response::success($trips, "User trip history retrieved");
    }

    public function store() {
        $data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $userId = $_SESSION['user']['userId'] ?? ($data['userId'] ?? 'USR-8829');
        $res = $this->tripModel->create($userId, $data);
        return Response::success($res, "Trip logged to user profile", 201);
    }
}
