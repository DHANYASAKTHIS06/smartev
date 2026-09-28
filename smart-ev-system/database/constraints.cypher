// Smart EV Charging Network - Neo4j AuraDB Constraints Setup
// Run these commands in Neo4j Aura Browser / Workspace Query tab

CREATE CONSTRAINT user_id_unique IF NOT EXISTS FOR (u:User) REQUIRE u.userId IS UNIQUE;
CREATE CONSTRAINT user_email_unique IF NOT EXISTS FOR (u:User) REQUIRE u.email IS UNIQUE;

CREATE CONSTRAINT ev_id_unique IF NOT EXISTS FOR (e:EV) REQUIRE e.evId IS UNIQUE;

CREATE CONSTRAINT location_id_unique IF NOT EXISTS FOR (l:Location) REQUIRE l.locationId IS UNIQUE;

CREATE CONSTRAINT road_id_unique IF NOT EXISTS FOR (r:Road) REQUIRE r.roadId IS UNIQUE;

CREATE CONSTRAINT station_id_unique IF NOT EXISTS FOR (s:ChargingStation) REQUIRE s.stationId IS UNIQUE;

CREATE CONSTRAINT charger_id_unique IF NOT EXISTS FOR (c:ChargingPoint) REQUIRE c.chargerId IS UNIQUE;

CREATE CONSTRAINT trip_id_unique IF NOT EXISTS FOR (t:Trip) REQUIRE t.tripId IS UNIQUE;

CREATE CONSTRAINT session_id_unique IF NOT EXISTS FOR (cs:ChargingSession) REQUIRE cs.sessionId IS UNIQUE;

CREATE CONSTRAINT demand_id_unique IF NOT EXISTS FOR (d:DemandRecord) REQUIRE d.demandId IS UNIQUE;

CREATE CONSTRAINT notification_id_unique IF NOT EXISTS FOR (n:Notification) REQUIRE n.notificationId IS UNIQUE;
