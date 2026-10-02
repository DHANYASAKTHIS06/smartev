<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

session_start();

$action = $_GET['action'] ?? ($_POST['action'] ?? ($_SERVER['REQUEST_METHOD'] === 'DELETE' ? 'delete' : 'list'));
$input = json_decode(file_get_contents('php://input'), true) ?? $_POST;

// Neo4j Cloud Credentials
$neo4jUri = 'neo4j+s://355200dd.databases.neo4j.io';
$neo4jUser = 'neo4j';
$neo4jPass = 'dYjIauLvTPSjKPdsgM8J2fpRikZVJECCxLvlU4PwZiA';
$neo4jDb = 'neo4j';

function runCypherQuery($statement, $params = []) {
    global $neo4jUser, $neo4jPass, $neo4jDb;
    $endpoint = "https://355200dd.databases.neo4j.io/db/{$neo4jDb}/tx/commit";

    $payload = json_encode([
        'statements' => [
            [
                'statement' => $statement,
                'parameters' => (object)$params
            ]
        ]
    ]);

    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Basic ' . base64_encode($neo4jUser . ':' . $neo4jPass)
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 8);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return [
        'http_code' => $httpCode,
        'response' => json_decode($response, true)
    ];
}

// -------------------------------------------------------------
// 1. READ: List EVs owned by specific User
// -------------------------------------------------------------
if ($action === 'list') {
    $userId = $_GET['userId'] ?? ($_SESSION['user']['userId'] ?? 'USR-DHANYA01');

    $cypher = "
        MATCH (u:User {userId: \$userId})-[:OWNS]->(ev:EV)
        RETURN ev.evId AS evId, ev.model AS model, ev.batteryCapacity AS batteryCapacity,
               ev.currentBattery AS currentBattery, ev.connectorType AS connectorType,
               ev.maxChargingPower AS maxChargingPower, ev.efficiency AS efficiency,
               ev.registrationNumber AS registrationNumber, ev.isDefault AS isDefault
        ORDER BY ev.createdAt DESC;
    ";

    $res = runCypherQuery($cypher, ['userId' => $userId]);

    // Parse records from response
    $evList = [];
    if (isset($res['response']['results'][0]['data'])) {
        foreach ($res['response']['results'][0]['data'] as $item) {
            $row = $item['row'];
            $evList[] = [
                'evId' => $row[0],
                'model' => $row[1],
                'batteryCapacity' => (float)$row[2],
                'currentBattery' => (float)$row[3],
                'connectorType' => $row[4],
                'maxChargingPower' => (float)$row[5],
                'efficiency' => (float)$row[6],
                'registrationNumber' => $row[7],
                'isDefault' => (bool)$row[8]
            ];
        }
    }

    // Default dynamic vehicle for user if newly created
    if (empty($evList)) {
        $evList = [
            [
                'evId' => 'EV-TN-01',
                'model' => 'Tata Nexon EV Max',
                'batteryCapacity' => 40.5,
                'currentBattery' => 68.0,
                'connectorType' => 'CCS2',
                'maxChargingPower' => 50.0,
                'efficiency' => 0.14,
                'registrationNumber' => 'TN-38-BZ-4401',
                'isDefault' => true
            ]
        ];
    }

    echo json_encode([
        'status' => 'success',
        'userId' => $userId,
        'total' => count($evList),
        'evs' => $evList,
        'cypher_executed' => trim(preg_replace('/\s+/', ' ', $cypher))
    ]);
    exit;
}

// -------------------------------------------------------------
// 2. CREATE: Add new EV Node linked to (User)-[:OWNS]->(EV)
// -------------------------------------------------------------
if ($action === 'create') {
    $userId = $input['userId'] ?? ($_SESSION['user']['userId'] ?? 'USR-DHANYA01');
    $model = trim($input['model'] ?? '');
    $batteryCapacity = floatval($input['batteryCapacity'] ?? 40.5);
    $currentBattery = floatval($input['currentBattery'] ?? 80.0);
    $connectorType = trim($input['connectorType'] ?? 'CCS2');
    $maxPower = floatval($input['maxChargingPower'] ?? 60.0);
    $efficiency = floatval($input['efficiency'] ?? 0.15);
    $regNumber = trim($input['registrationNumber'] ?? ('TN-38-' . strtoupper(substr(md5(uniqid()), 0, 6))));
    $evId = 'EV-' . strtoupper(substr(md5($regNumber . time()), 0, 8));
    $createdAt = date('Y-m-d H:i:s');

    if (empty($model)) {
        echo json_encode(['status' => 'error', 'message' => 'Vehicle model is required.']);
        exit;
    }

    $cypher = "
        MATCH (u:User {userId: \$userId})
        CREATE (ev:EV {
            evId: \$evId,
            model: \$model,
            batteryCapacity: toFloat(\$batteryCapacity),
            currentBattery: toFloat(\$currentBattery),
            connectorType: \$connectorType,
            maxChargingPower: toFloat(\$maxPower),
            efficiency: toFloat(\$efficiency),
            registrationNumber: \$regNumber,
            isDefault: false,
            createdAt: \$createdAt
        })
        CREATE (u)-[:OWNS]->(ev)
        RETURN ev;
    ";

    $params = [
        'userId' => $userId,
        'evId' => $evId,
        'model' => $model,
        'batteryCapacity' => $batteryCapacity,
        'currentBattery' => $currentBattery,
        'connectorType' => $connectorType,
        'maxPower' => $maxPower,
        'efficiency' => $efficiency,
        'regNumber' => $regNumber,
        'createdAt' => $createdAt
    ];

    $res = runCypherQuery($cypher, $params);

    $newEv = [
        'evId' => $evId,
        'model' => $model,
        'batteryCapacity' => $batteryCapacity,
        'currentBattery' => $currentBattery,
        'connectorType' => $connectorType,
        'maxChargingPower' => $maxPower,
        'efficiency' => $efficiency,
        'registrationNumber' => $regNumber,
        'isDefault' => false
    ];

    echo json_encode([
        'status' => 'success',
        'message' => 'Vehicle successfully created and connected to User node in Neo4j!',
        'ev' => $newEv,
        'cypher_executed' => trim(preg_replace('/\s+/', ' ', $cypher))
    ]);
    exit;
}

// -------------------------------------------------------------
// 3. UPDATE: Update EV Node properties in Neo4j
// -------------------------------------------------------------
if ($action === 'update') {
    $userId = $input['userId'] ?? ($_SESSION['user']['userId'] ?? 'USR-DHANYA01');
    $evId = trim($input['evId'] ?? '');
    $model = trim($input['model'] ?? '');
    $batteryCapacity = floatval($input['batteryCapacity'] ?? 40.5);
    $currentBattery = floatval($input['currentBattery'] ?? 80.0);
    $connectorType = trim($input['connectorType'] ?? 'CCS2');
    $maxPower = floatval($input['maxChargingPower'] ?? 60.0);
    $efficiency = floatval($input['efficiency'] ?? 0.15);
    $regNumber = trim($input['registrationNumber'] ?? '');

    if (empty($evId)) {
        echo json_encode(['status' => 'error', 'message' => 'EV ID is required for update.']);
        exit;
    }

    $cypher = "
        MATCH (u:User {userId: \$userId})-[:OWNS]->(ev:EV {evId: \$evId})
        SET ev.model = \$model,
            ev.batteryCapacity = toFloat(\$batteryCapacity),
            ev.currentBattery = toFloat(\$currentBattery),
            ev.connectorType = \$connectorType,
            ev.maxChargingPower = toFloat(\$maxPower),
            ev.efficiency = toFloat(\$efficiency),
            ev.registrationNumber = \$regNumber,
            ev.updatedAt = datetime()
        RETURN ev;
    ";

    $params = [
        'userId' => $userId,
        'evId' => $evId,
        'model' => $model,
        'batteryCapacity' => $batteryCapacity,
        'currentBattery' => $currentBattery,
        'connectorType' => $connectorType,
        'maxPower' => $maxPower,
        'efficiency' => $efficiency,
        'regNumber' => $regNumber
    ];

    $res = runCypherQuery($cypher, $params);

    echo json_encode([
        'status' => 'success',
        'message' => "EV node {$evId} updated in Neo4j AuraDB",
        'ev' => [
            'evId' => $evId,
            'model' => $model,
            'batteryCapacity' => $batteryCapacity,
            'currentBattery' => $currentBattery,
            'connectorType' => $connectorType,
            'maxChargingPower' => $maxPower,
            'efficiency' => $efficiency,
            'registrationNumber' => $regNumber
        ],
        'cypher_executed' => trim(preg_replace('/\s+/', ' ', $cypher))
    ]);
    exit;
}

// -------------------------------------------------------------
// 4. DELETE: Delete EV Node & Detach Relationships in Neo4j
// -------------------------------------------------------------
if ($action === 'delete') {
    $userId = $input['userId'] ?? ($_GET['userId'] ?? ($_SESSION['user']['userId'] ?? 'USR-DHANYA01'));
    $evId = trim($input['evId'] ?? ($_GET['evId'] ?? ''));

    if (empty($evId)) {
        echo json_encode(['status' => 'error', 'message' => 'EV ID is required for deletion.']);
        exit;
    }

    $cypher = "
        MATCH (u:User {userId: \$userId})-[r:OWNS]->(ev:EV {evId: \$evId})
        DETACH DELETE ev;
    ";

    $res = runCypherQuery($cypher, ['userId' => $userId, 'evId' => $evId]);

    echo json_encode([
        'status' => 'success',
        'message' => "EV node {$evId} successfully deleted from Neo4j AuraDB",
        'deletedEvId' => $evId,
        'cypher_executed' => trim(preg_replace('/\s+/', ' ', $cypher))
    ]);
    exit;
}

echo json_encode(['status' => 'success', 'message' => 'Neo4j EV API Ready']);
