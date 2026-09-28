<?php
namespace Models;

require_once __DIR__ . '/../core/Neo4jConnection.php';
use Core\Neo4jConnection;

class Notification {
    private $db;

    public function __construct() {
        $this->db = Neo4jConnection::getInstance();
    }

    public function create(string $userId, array $data) {
        $notificationId = $data['notificationId'] ?? ('NOTIF-' . uniqid());
        $cypher = "
            MATCH (u:User {userId: \$userId})
            CREATE (n:Notification {
                notificationId: \$notificationId,
                title: \$title,
                message: \$message,
                type: \$type,
                isRead: false,
                createdAt: \$createdAt
            })
            CREATE (u)-[:RECEIVES]->(n)
            RETURN n;
        ";
        $params = [
            'userId'         => $userId,
            'notificationId' => $notificationId,
            'title'          => $data['title'],
            'message'        => $data['message'],
            'type'           => $data['type'] ?? 'INFO',
            'createdAt'      => date('Y-m-d H:i:s')
        ];
        return $this->db->runQuery($cypher, $params);
    }

    public function getByUserId(string $userId) {
        $cypher = "
            MATCH (u:User {userId: \$userId})-[:RECEIVES]->(n:Notification)
            RETURN n.notificationId AS notificationId, n.title AS title, n.message AS message,
                   n.type AS type, n.isRead AS isRead, n.createdAt AS createdAt
            ORDER BY n.createdAt DESC;
        ";
        return $this->db->runQuery($cypher, ['userId' => $userId]);
    }

    public function markAsRead(string $notificationId) {
        $cypher = "
            MATCH (n:Notification {notificationId: \$notificationId})
            SET n.isRead = true
            RETURN n;
        ";
        return $this->db->runQuery($cypher, ['notificationId' => $notificationId]);
    }
}
