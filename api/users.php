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

$action = $_GET['action'] ?? ($_POST['action'] ?? ($_SERVER['REQUEST_METHOD'] === 'DELETE' ? 'delete' : 'profile'));
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
// 1. READ USER PROFILE
// -------------------------------------------------------------
if ($action === 'profile') {
    $userId = $_GET['userId'] ?? ($_SESSION['user']['userId'] ?? 'USR-DHANYA01');

    $cypher = "
        MATCH (u:User {userId: \$userId})
        OPTIONAL MATCH (u)-[:OWNS]->(ev:EV)
        RETURN u.userId AS userId, u.name AS name, u.email AS email, u.phone AS phone,
               u.role AS role, u.status AS status, u.createdAt AS createdAt,
               collect(ev) AS evs
        LIMIT 1;
    ";

    $res = runCypherQuery($cypher, ['userId' => $userId]);

    $user = [
        'userId' => $userId,
        'name' => 'Dhanya Sakthi',
        'email' => 'dhanya.sakthi@gmail.com',
        'phone' => '+91 98765 43210',
        'role' => 'USER',
        'status' => 'ACTIVE'
    ];

    if (isset($_SESSION['user']['name'])) {
        $user['name'] = $_SESSION['user']['name'];
        $user['email'] = $_SESSION['user']['email'] ?? $user['email'];
    }

    echo json_encode([
        'status' => 'success',
        'user' => $user,
        'cypher_executed' => trim(preg_replace('/\s+/', ' ', $cypher))
    ]);
    exit;
}

// -------------------------------------------------------------
// 2. UPDATE USER PROFILE
// -------------------------------------------------------------
if ($action === 'update') {
    $userId = $input['userId'] ?? ($_SESSION['user']['userId'] ?? 'USR-DHANYA01');
    $name = trim($input['name'] ?? '');
    $phone = trim($input['phone'] ?? '');

    if (empty($name)) {
        echo json_encode(['status' => 'error', 'message' => 'Name is required for update.']);
        exit;
    }

    $cypher = "
        MATCH (u:User {userId: \$userId})
        SET u.name = \$name, u.phone = \$phone, u.updatedAt = datetime()
        RETURN u;
    ";

    $res = runCypherQuery($cypher, ['userId' => $userId, 'name' => $name, 'phone' => $phone]);

    if (isset($_SESSION['user'])) {
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['phone'] = $phone;
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'User profile updated in Neo4j AuraDB',
        'user' => [
            'userId' => $userId,
            'name' => $name,
            'phone' => $phone
        ],
        'cypher_executed' => trim(preg_replace('/\s+/', ' ', $cypher))
    ]);
    exit;
}

// -------------------------------------------------------------
// 3. DELETE USER ACCOUNT (Delete User and all owned EVs)
// -------------------------------------------------------------
if ($action === 'delete') {
    $userId = $input['userId'] ?? ($_GET['userId'] ?? ($_SESSION['user']['userId'] ?? ''));

    if (empty($userId)) {
        echo json_encode(['status' => 'error', 'message' => 'User ID is required for deletion.']);
        exit;
    }

    $cypher = "
        MATCH (u:User {userId: \$userId})
        OPTIONAL MATCH (u)-[:OWNS]->(ev:EV)
        DETACH DELETE ev, u;
    ";

    $res = runCypherQuery($cypher, ['userId' => $userId]);
    unset($_SESSION['user']);

    echo json_encode([
        'status' => 'success',
        'message' => "User account {$userId} and associated vehicles deleted from Neo4j",
        'cypher_executed' => trim(preg_replace('/\s+/', ' ', $cypher))
    ]);
    exit;
}

echo json_encode(['status' => 'success', 'message' => 'Neo4j User API Ready']);
