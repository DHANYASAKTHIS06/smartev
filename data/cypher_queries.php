<?php
/**
 * Cypher Query Library for Neo4j EV Graph Operations
 * Contains pre-compiled Cypher queries used by the backend API and visualizer
 */

return [
    'find_shortest_path' => "
        MATCH (start:Location {id: \$startId}), (end:Location {id: \$endId})
        MATCH p = shortestPath((start)-[:ROAD*..10]->(end))
        RETURN p, reduce(dist = 0, r IN relationships(p) | dist + r.distance_km) AS totalDistance;
    ",

    'recommend_charging_stations' => "
        MATCH (loc:Location {name: \$locationName})-[r:CONNECTED_TO*1..2]-(s:ChargingStation)
        WHERE s.available_chargers > 0 AND \$connector IN s.connectors
        WITH s, min(r.distance_km) AS distance
        MATCH (s)-[:HAS_CHARGER]->(c:ChargingPoint)
        RETURN s.id AS stationId, s.name AS stationName, s.address AS address, 
               s.charging_speed_kw AS speedKw, s.price_per_kwh AS pricePerKwh, 
               s.available_chargers AS available, s.total_chargers AS total,
               s.predicted_demand_pct AS predictedDemand, distance
        ORDER BY distance ASC, s.predicted_demand_pct ASC
        LIMIT 5;
    ",

    'predictive_demand_analysis' => "
        MATCH (s:ChargingStation {id: \$stationId})-[r:HAS_DEMAND_RECORD]->(d:DemandMetric)
        WHERE d.timestamp >= datetime() AND d.timestamp <= datetime() + duration('P1D')
        RETURN d.hour AS hourOfDay, d.occupancy_rate AS occupancyRate, 
               d.queue_length AS queueLength, d.predicted_wait_min AS waitMinutes
        ORDER BY d.hour ASC;
    ",

    'battery_safe_journey' => "
        MATCH (ev:EV {id: \$evId})
        MATCH (start:Location {id: \$startId}), (target:Location {id: \$targetId})
        MATCH path = (start)-[:ROAD*..8]->(target)
        WITH path, nodes(path) AS pathNodes, 
             reduce(e = 0, r IN relationships(path) | e + (r.distance_km * ev.consumption_rate_kwh_km)) AS requiredEnergy
        WHERE requiredEnergy <= (\$currentBatteryKwh - \$safetyMarginKwh)
        RETURN path, requiredEnergy, size(pathNodes) AS hopCount
        ORDER BY requiredEnergy ASC LIMIT 3;
    ",

    'graph_visualization_extract' => "
        MATCH (n)
        OPTIONAL MATCH (n)-[r]->(m)
        RETURN labels(n)[0] AS nodeType, id(n) AS nodeId, n AS nodeProps,
               type(r) AS relType, id(m) AS targetId, r AS relProps
        LIMIT 150;
    "
];
