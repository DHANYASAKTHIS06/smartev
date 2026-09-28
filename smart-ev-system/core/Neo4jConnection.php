<?php
namespace Core;

require_once __DIR__ . '/../config/database.php';
use Config\Database;

class Neo4jConnection {
    private static $instance = null;
    private $config;

    private function __construct() {
        $this->config = Database::getConfig();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Run parameterized Cypher query against Neo4j AuraDB via Transactional HTTPS / Bolt API
     */
    public function runQuery(string $statement, array $parameters = []) {
        $httpUri = rtrim($this->config['http_uri'], '/');
        $dbName  = $this->config['database'] ?: 'neo4j';
        $endpoint = "{$httpUri}/db/{$dbName}/tx/commit";

        // Format Cypher payload for Neo4j HTTP Transaction API
        $payload = json_encode([
            'statements' => [
                [
                    'statement' => $statement,
                    'parameters' => (object)$parameters
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
            'Authorization: Basic ' . base64_encode($this->config['username'] . ':' . $this->config['password'])
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \Exception("Neo4j cURL Connection Error: " . $error);
        }

        $result = json_decode($response, true);

        if (!empty($result['errors'])) {
            $msg = $result['errors'][0]['message'] ?? 'Cypher query error';
            throw new \Exception("Neo4j AuraDB Error: " . $msg);
        }

        return $this->formatResults($result);
    }

    /**
     * Format raw HTTP response into clean array of key-value records
     */
    private function formatResults($raw) {
        $records = [];
        if (!isset($raw['results'][0]['data'])) {
            return [];
        }

        $columns = $raw['results'][0]['columns'] ?? [];
        foreach ($raw['results'][0]['data'] as $item) {
            $row = [];
            foreach ($columns as $idx => $col) {
                $row[$col] = $item['row'][$idx] ?? null;
            }
            $records[] = $row;
        }
        return $records;
    }
}
