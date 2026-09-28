// Smart EV Charging Network - Neo4j Aura Demonstration Queries
// Run these queries in Neo4j Aura Query Workspace to test graph traversals

// 1. Get all registered EV models and owner details
MATCH (u:User)-[:OWNS]->(e:EV)
RETURN u.name AS Owner, u.email AS Email, e.model AS EVModel, e.batteryCapacity AS Capacity, e.connectorType AS Connector;

// 2. Query all charging stations and their available ports
MATCH (l:Location)-[:HAS_STATION]->(s:ChargingStation)
RETURN l.name AS Location, s.name AS StationName, s.chargingSpeed AS SpeedKw, s.availableChargers AS Available, s.pricePerKwh AS PricePerKwh;

// 3. Find reachable stations with CCS2 connectors within shortest path distance
MATCH (l:Location {city: 'Coimbatore'})-[:HAS_STATION]->(s:ChargingStation)-[:HAS_CHARGER]->(c:ChargingPoint {connectorType: 'CCS2'})
RETURN s.name AS Station, s.chargingSpeed AS Speed, c.chargerId AS PortId, s.operatingStatus AS Status;

// 4. Graph Shortest Path Traversal between Coimbatore and Salem
MATCH (start:Location {name: 'Coimbatore Central'}), (end:Location {name: 'Salem Steel Plaza'})
MATCH p = shortestPath((start)-[:CONNECTED_TO*..10]->(end))
RETURN p, reduce(totalDist = 0, r IN relationships(p) | totalDist + r.distance) AS TotalDistanceKm;

// 5. Query user trip history and energy consumed
MATCH (u:User {userId: 'USR-8829'})-[:PLANNED]->(t:Trip)
RETURN t.tripId AS TripId, t.startLocation AS Start, t.destination AS Dest, t.distance AS DistanceKm, t.chargingCost AS CostINR, t.createdAt AS Date;

// 6. High-demand charging station forecasting (> 80% demand)
MATCH (s:ChargingStation)-[:HAS_DEMAND]->(d:DemandRecord)
WHERE d.demandLevel IN ['HIGH', 'VERY HIGH']
RETURN s.name AS Station, d.hour AS HourOfDay, d.chargingSessions AS ActiveSessions, d.waitingTime AS QueueWaitMin;

// 7. Graph Network Topology Visualization
MATCH (n) OPTIONAL MATCH (n)-[r]->(m) RETURN n, r, m LIMIT 100;
