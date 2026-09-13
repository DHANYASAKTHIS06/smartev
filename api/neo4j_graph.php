<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/config.php';
$sampleData = require __DIR__ . '/../data/sample_data.php';

$filterType = strtolower($_GET['type'] ?? 'all');

$nodes = $sampleData['neo4j_graph_nodes'];
$edges = $sampleData['neo4j_graph_edges'];

if ($filterType !== 'all') {
    $nodes = array_values(array_filter($nodes, function($n) use ($filterType) {
        return $n['type'] === $filterType;
    }));
    $validIds = array_map(function($n) { return $n['id']; }, $nodes);
    $edges = array_values(array_filter($edges, function($e) use ($validIds) {
        return in_array($e['from'], $validIds) && in_array($e['to'], $validIds);
    }));
}

echo json_encode([
    'status' => 'success',
    'cypher' => "MATCH (n:EV)-[r1:LOCATED_AT]->(l:Location)-[r2:CONNECTED_TO]->(s:ChargingStation)-[r3:HAS_CHARGER]->(p:ChargingPoint) RETURN n, r1, l, r2, s, r3, p LIMIT 100;",
    'nodes' => $nodes,
    'edges' => $edges
]);
