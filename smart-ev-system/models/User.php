<?php
namespace Models;

require_once __DIR__ . '/../core/Neo4jConnection.php';
use Core\Neo4jConnection;

class User {
    private $db;

    public function __construct() {
        $this->db = Neo4jConnection::getInstance();
    }

    public function create(array $data) {
        $cypher = "
            CREATE (u:User {
                userId: \$userId,
                name: \$name,
                email: \$email,
                phone: \$phone,
                passwordHash: \$passwordHash,
                role: \$role,
                status: \$status,
                createdAt: \$createdAt
            })
            RETURN u;
        ";
        $params = [
            'userId'       => $data['userId'] ?? ('USR-' . uniqid()),
            'name'         => $data['name'],
            'email'        => strtolower(trim($data['email'])),
            'phone'        => $data['phone'] ?? '',
            'passwordHash' => $data['passwordHash'],
            'role'         => strtoupper($data['role'] ?? 'USER'),
            'status'       => $data['status'] ?? 'ACTIVE',
            'createdAt'    => date('Y-m-d H:i:s')
        ];
        return $this->db->runQuery($cypher, $params);
    }

    public function findByEmail(string $email) {
        $cypher = "MATCH (u:User {email: \$email}) RETURN u.userId AS userId, u.name AS name, u.email AS email, u.phone AS phone, u.passwordHash AS passwordHash, u.role AS role, u.status AS status, u.createdAt AS createdAt LIMIT 1;";
        $rows = $this->db->runQuery($cypher, ['email' => strtolower(trim($email))]);
        return $rows[0] ?? null;
    }

    public function findById(string $userId) {
        $cypher = "MATCH (u:User {userId: \$userId}) RETURN u.userId AS userId, u.name AS name, u.email AS email, u.phone AS phone, u.role AS role, u.status AS status, u.createdAt AS createdAt LIMIT 1;";
        $rows = $this->db->runQuery($cypher, ['userId' => $userId]);
        return $rows[0] ?? null;
    }

    public function getAll() {
        $cypher = "MATCH (u:User) RETURN u.userId AS userId, u.name AS name, u.email AS email, u.phone AS phone, u.role AS role, u.status AS status ORDER BY u.createdAt DESC;";
        return $this->db->runQuery($cypher);
    }

    public function update(string $userId, array $data) {
        $cypher = "
            MATCH (u:User {userId: \$userId})
            SET u.name = \$name, u.phone = \$phone, u.status = \$status
            RETURN u;
        ";
        return $this->db->runQuery($cypher, [
            'userId' => $userId,
            'name'   => $data['name'],
            'phone'  => $data['phone'] ?? '',
            'status' => $data['status'] ?? 'ACTIVE'
        ]);
    }

    public function delete(string $userId) {
        $cypher = "MATCH (u:User {userId: \$userId}) DETACH DELETE u;";
        return $this->db->runQuery($cypher, ['userId' => $userId]);
    }
}
