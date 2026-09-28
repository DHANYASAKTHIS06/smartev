// Smart EV Charging Network - Neo4j AuraDB Indexes
// Optimizes property search performance for frequently queried labels

CREATE INDEX station_name_index IF NOT EXISTS FOR (s:ChargingStation) ON (s.name);
CREATE INDEX station_status_index IF NOT EXISTS FOR (s:ChargingStation) ON (s.operatingStatus);

CREATE INDEX location_name_index IF NOT EXISTS FOR (l:Location) ON (l.name);
CREATE INDEX location_city_index IF NOT EXISTS FOR (l:Location) ON (l.city);

CREATE INDEX ev_model_index IF NOT EXISTS FOR (e:EV) ON (e.model);
CREATE INDEX ev_connector_index IF NOT EXISTS FOR (e:EV) ON (e.connectorType);

CREATE INDEX demand_timestamp_index IF NOT EXISTS FOR (d:DemandRecord) ON (d.timestamp);

CREATE INDEX trip_created_index IF NOT EXISTS FOR (t:Trip) ON (t.createdAt);
