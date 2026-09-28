// Smart EV Charging Network - Neo4j Graph Data Model Schema
// Conceptually displays graph nodes, properties, and directed relationships

/*
GRAPH SCHEMA RELATIONSHIP MAP:

(User)-[:OWNS]->(EV)
(User)-[:PLANNED]->(Trip)
(User)-[:RECEIVES]->(Notification)
(User)-[:FAVORITES_STATION]->(ChargingStation)
(User)-[:FAVORITES_TRIP]->(Trip)

(EV)-[:LOCATED_AT]->(Location)
(EV)-[:HAS_SESSION]->(ChargingSession)

(Location)-[:CONNECTED_TO {distance, travelTime, trafficLevel, energyCost}]->(Location)
(Location)-[:HAS_STATION]->(ChargingStation)

(ChargingStation)-[:HAS_CHARGER]->(ChargingPoint)
(ChargingStation)-[:HAS_DEMAND]->(DemandRecord)

(ChargingSession)-[:AT_STATION]->(ChargingStation)
*/

// Schema Overview Cypher Query:
CALL db.schema.visualization();
