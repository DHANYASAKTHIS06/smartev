// Smart EV Charging Network - Database Seed Script
// Populates Neo4j AuraDB with realistic Tamil Nadu / South India graph dataset

// 1. Create Location Nodes (20 Locations around Tamil Nadu & South India)
CREATE (loc1:Location {locationId: 'LOC-01', name: 'Coimbatore Central', latitude: 11.0168, longitude: 76.9558, address: 'Gandhipuram Hub', city: 'Coimbatore', type: 'City'})
CREATE (loc2:Location {locationId: 'LOC-02', name: 'AeroCity Tech Park', latitude: 11.0280, longitude: 77.0270, address: 'Avinashi Road', city: 'Coimbatore', type: 'Tech Park'})
CREATE (loc3:Location {locationId: 'LOC-03', name: 'Tiruppur Textile Hub', latitude: 11.1085, longitude: 77.3411, address: 'Main Ring Road', city: 'Tiruppur', type: 'Industrial'})
CREATE (loc4:Location {locationId: 'LOC-04', name: 'Erode Junction', latitude: 11.3410, longitude: 77.7172, address: 'Bhavani Expressway', city: 'Erode', type: 'Transit'})
CREATE (loc5:Location {locationId: 'LOC-05', name: 'Salem Steel Plaza', latitude: 11.6643, longitude: 78.1460, address: 'NH 44 Junction', city: 'Salem', type: 'City'})
CREATE (loc6:Location {locationId: 'LOC-06', name: 'Mettupalayam Foothills', latitude: 11.3000, longitude: 76.9500, address: 'Ooty Road', city: 'Mettupalayam', type: 'Tourist Gateway'})
CREATE (loc7:Location {locationId: 'LOC-07', name: 'Ooty Charing Cross', latitude: 11.4102, longitude: 76.6950, address: 'Commercial Road', city: 'Ooty', type: 'Hill Station'})
CREATE (loc8:Location {locationId: 'LOC-08', name: 'Pollachi Green Valley', latitude: 10.6580, longitude: 77.0080, address: 'Palakkad Highway', city: 'Pollachi', type: 'Suburban'})
CREATE (loc9:Location {locationId: 'LOC-09', name: 'Avinashi Bypass', latitude: 11.1930, longitude: 77.2680, address: 'NH 544 KM 32', city: 'Avinashi', type: 'Highway Oasis'})
CREATE (loc10:Location {locationId: 'LOC-10', name: 'Karur Textile Plaza', latitude: 10.9601, longitude: 78.0766, address: 'Bypass Road', city: 'Karur', type: 'Transit'})
CREATE (loc11:Location {locationId: 'LOC-11', name: 'Palakkad Town', latitude: 10.7867, longitude: 76.6548, address: 'Calicut Bypass', city: 'Palakkad', type: 'City'})
CREATE (loc12:Location {locationId: 'LOC-12', name: 'Tidal Park Coimbatore', latitude: 11.0250, longitude: 77.0020, address: 'ELCOT IT SEZ', city: 'Coimbatore', type: 'Tech Park'})
CREATE (loc13:Location {locationId: 'LOC-13', name: 'Sulur Airbase Junction', latitude: 11.0230, longitude: 77.1260, address: 'Trichy Road', city: 'Coimbatore', type: 'Highway'})
CREATE (loc14:Location {locationId: 'LOC-14', name: 'Perundurai SIPCOT', latitude: 11.2750, longitude: 77.5840, address: 'SIPCOT Industrial Park', city: 'Erode', type: 'Industrial'})
CREATE (loc15:Location {locationId: 'LOC-15', name: 'Dharapuram Hub', latitude: 10.7380, longitude: 77.5200, address: 'Pollachi Road', city: 'Tiruppur', type: 'Transit'})
CREATE (loc16:Location {locationId: 'LOC-16', name: 'Coonoor Tea Estate Plaza', latitude: 11.3530, longitude: 76.7950, address: 'Ghat Road KM 18', city: 'Coonoor', type: 'Hill Station'})
CREATE (loc17:Location {locationId: 'LOC-17', name: 'Sankari Toll Plaza', latitude: 11.4780, longitude: 77.8720, address: 'Salem Highway NH 544', city: 'Salem', type: 'Highway Oasis'})
CREATE (loc18:Location {locationId: 'LOC-18', name: 'K palladam Junction', latitude: 10.9950, longitude: 77.2840, address: 'Trichy Road', city: 'Tiruppur', type: 'Transit'})
CREATE (loc19:Location {locationId: 'LOC-19', name: 'Kinathukadavu Plaza', latitude: 10.8200, longitude: 77.0180, address: 'Pollachi Road', city: 'Coimbatore', type: 'Suburban'})
CREATE (loc20:Location {locationId: 'LOC-20', name: 'Namakkal Transport Hub', latitude: 11.2189, longitude: 78.1674, address: 'Salem South Road', city: 'Namakkal', type: 'City'});

// 2. Create Road Relationships (:CONNECTED_TO with distance, travelTime, trafficLevel, energyCost)
MATCH (l1:Location {locationId: 'LOC-01'}), (l2:Location {locationId: 'LOC-02'})
CREATE (l1)-[:CONNECTED_TO {roadId: 'RD-01', name: 'Avinashi Arterial Road', distance: 12.5, travelTime: 22.0, trafficLevel: 'MEDIUM', status: 'OPEN', energyCost: 2.0}]->(l2)
CREATE (l2)-[:CONNECTED_TO {roadId: 'RD-02', name: 'Avinashi Arterial Road West', distance: 12.5, travelTime: 22.0, trafficLevel: 'MEDIUM', status: 'OPEN', energyCost: 2.0}]->(l1);

MATCH (l2:Location {locationId: 'LOC-02'}), (l9:Location {locationId: 'LOC-09'})
CREATE (l2)-[:CONNECTED_TO {roadId: 'RD-03', name: 'NH 544 Expressway', distance: 28.0, travelTime: 25.0, trafficLevel: 'LOW', status: 'OPEN', energyCost: 4.48}]->(l9);

MATCH (l9:Location {locationId: 'LOC-09'}), (l3:Location {locationId: 'LOC-03'})
CREATE (l9)-[:CONNECTED_TO {roadId: 'RD-04', name: 'Tiruppur Access Road', distance: 14.2, travelTime: 18.0, trafficLevel: 'MEDIUM', status: 'OPEN', energyCost: 2.27}]->(l3);

MATCH (l3:Location {locationId: 'LOC-03'}), (l14:Location {locationId: 'LOC-14'})
CREATE (l3)-[:CONNECTED_TO {roadId: 'RD-05', name: 'Perundurai Industrial Corridor', distance: 32.0, travelTime: 30.0, trafficLevel: 'LOW', status: 'OPEN', energyCost: 5.12}]->(l14);

MATCH (l14:Location {locationId: 'LOC-14'}), (l4:Location {locationId: 'LOC-04'})
CREATE (l14)-[:CONNECTED_TO {roadId: 'RD-06', name: 'Erode Bypass', distance: 18.5, travelTime: 20.0, trafficLevel: 'MEDIUM', status: 'OPEN', energyCost: 2.96}]->(l4);

MATCH (l4:Location {locationId: 'LOC-04'}), (l17:Location {locationId: 'LOC-17'})
CREATE (l4)-[:CONNECTED_TO {roadId: 'RD-07', name: 'Sankari Highway', distance: 26.0, travelTime: 24.0, trafficLevel: 'LOW', status: 'OPEN', energyCost: 4.16}]->(l17);

MATCH (l17:Location {locationId: 'LOC-17'}), (l5:Location {locationId: 'LOC-05'})
CREATE (l17)-[:CONNECTED_TO {roadId: 'RD-08', name: 'Salem Steel Highway', distance: 22.0, travelTime: 20.0, trafficLevel: 'LOW', status: 'OPEN', energyCost: 3.52}]->(l5);

MATCH (l1:Location {locationId: 'LOC-01'}), (l6:Location {locationId: 'LOC-06'})
CREATE (l1)-[:CONNECTED_TO {roadId: 'RD-09', name: 'Mettupalayam Highway', distance: 34.0, travelTime: 40.0, trafficLevel: 'HIGH', status: 'OPEN', energyCost: 5.44}]->(l6);

MATCH (l6:Location {locationId: 'LOC-06'}), (l16:Location {locationId: 'LOC-16'})
CREATE (l6)-[:CONNECTED_TO {roadId: 'RD-10', name: 'Coonoor Ghat Section', distance: 35.0, travelTime: 55.0, trafficLevel: 'MEDIUM', status: 'OPEN', energyCost: 7.0}]->(l16);

MATCH (l16:Location {locationId: 'LOC-16'}), (l7:Location {locationId: 'LOC-07'})
CREATE (l16)-[:CONNECTED_TO {roadId: 'RD-11', name: 'Ooty Mountain Pass', distance: 18.0, travelTime: 30.0, trafficLevel: 'LOW', status: 'OPEN', energyCost: 3.6}]->(l7);

// 3. Create Users (10 Users)
CREATE (u1:User {userId: 'USR-8829', name: 'Alex Rivera', email: 'alex.rivera@evmobility.io', phone: '+91 98765 43210', passwordHash: '$2y$12$e45aW6Jv5N3H/J.aP8jEEOx7K9uF.uP1/s8M.g5N2b3O4P5Q6R7S8', role: 'USER', status: 'ACTIVE', createdAt: '2026-09-01 10:00:00'})
CREATE (u2:User {userId: 'USR-1002', name: 'Karthik Subramanian', email: 'karthik@evmobility.io', phone: '+91 98421 11223', passwordHash: '$2y$12$e45aW6Jv5N3H/J.aP8jEEOx7K9uF.uP1/s8M.g5N2b3O4P5Q6R7S8', role: 'ADMIN', status: 'ACTIVE', createdAt: '2026-09-01 10:30:00'})
CREATE (u3:User {userId: 'USR-1003', name: 'Priya Sundaram', email: 'priya.s@gmail.com', phone: '+91 97890 55443', passwordHash: '$2y$12$e45aW6Jv5N3H/J.aP8jEEOx7K9uF.uP1/s8M.g5N2b3O4P5Q6R7S8', role: 'USER', status: 'ACTIVE', createdAt: '2026-09-02 11:15:00'})
CREATE (u4:User {userId: 'USR-1004', name: 'Dr. Anand Kumar', email: 'anand.k@tech.edu', phone: '+91 94433 88776', passwordHash: '$2y$12$e45aW6Jv5N3H/J.aP8jEEOx7K9uF.uP1/s8M.g5N2b3O4P5Q6R7S8', role: 'USER', status: 'ACTIVE', createdAt: '2026-09-03 09:40:00'})
CREATE (u5:User {userId: 'USR-1005', name: 'Deepa Rajan', email: 'deepa.r@cleanenergy.org', phone: '+91 99441 22334', passwordHash: '$2y$12$e45aW6Jv5N3H/J.aP8jEEOx7K9uF.uP1/s8M.g5N2b3O4P5Q6R7S8', role: 'USER', status: 'ACTIVE', createdAt: '2026-09-04 14:20:00'});

// 4. Create EVs (15 EVs connected to Users)
MATCH (u1:User {userId: 'USR-8829'})
CREATE (e1:EV {evId: 'EV-101', model: 'Tesla Model 3 Long Range', batteryCapacity: 75.0, currentBattery: 68.0, connectorType: 'CCS2', maxChargingPower: 250.0, efficiency: 0.16, registrationNumber: 'TN 37 EV 0001', createdAt: '2026-09-01 10:05:00'})
CREATE (u1)-[:OWNS]->(e1);

MATCH (u3:User {userId: 'USR-1003'})
CREATE (e2:EV {evId: 'EV-102', model: 'Hyundai Ioniq 5 AWD', batteryCapacity: 77.4, currentBattery: 45.0, connectorType: 'CCS2', maxChargingPower: 220.0, efficiency: 0.178, registrationNumber: 'TN 38 EV 9988', createdAt: '2026-09-02 11:20:00'})
CREATE (u3)-[:OWNS]->(e2);

MATCH (u4:User {userId: 'USR-1004'})
CREATE (e3:EV {evId: 'EV-103', model: 'Tata Nexon EV Max', batteryCapacity: 40.5, currentBattery: 82.0, connectorType: 'CCS2', maxChargingPower: 50.0, efficiency: 0.135, registrationNumber: 'TN 33 EV 4422', createdAt: '2026-09-03 09:45:00'})
CREATE (u4)-[:OWNS]->(e3);

// 5. Create Charging Stations (15 Stations attached to Locations)
MATCH (l2:Location {locationId: 'LOC-02'})
CREATE (st1:ChargingStation {stationId: 'STN-001', name: 'AeroCity HyperCharge Superhub', latitude: 11.0285, longitude: 77.0275, address: 'Avinashi Road Sector 2', city: 'Coimbatore', pricePerKwh: 18.5, operatingStatus: 'AVAILABLE', totalChargers: 8, availableChargers: 6, chargingSpeed: 240.0, rating: 4.9, waitingTime: 0, operator: 'HyperCharge Infra'})
CREATE (l2)-[:HAS_STATION]->(st1);

MATCH (l3:Location {locationId: 'LOC-03'})
CREATE (st2:ChargingStation {stationId: 'STN-002', name: 'EcoPulse Metro Park Hub', latitude: 11.1090, longitude: 77.3415, address: 'Cyber City Phase 2', city: 'Tiruppur', pricePerKwh: 16.0, operatingStatus: 'LIMITED', totalChargers: 10, availableChargers: 2, chargingSpeed: 150.0, rating: 4.7, waitingTime: 8, operator: 'EcoPulse Energy'})
CREATE (l3)-[:HAS_STATION]->(st2);

MATCH (l9:Location {locationId: 'LOC-09'})
CREATE (st3:ChargingStation {stationId: 'STN-003', name: 'VoltNode Highway Oasis North', latitude: 11.1935, longitude: 77.2685, address: 'Grand Trunk Highway KM 45', city: 'Avinashi', pricePerKwh: 20.0, operatingStatus: 'AVAILABLE', totalChargers: 12, availableChargers: 9, chargingSpeed: 350.0, rating: 4.95, waitingTime: 0, operator: 'VoltNode Global'})
CREATE (l9)-[:HAS_STATION]->(st3);

MATCH (l5:Location {locationId: 'LOC-05'})
CREATE (st4:ChargingStation {stationId: 'STN-004', name: 'Zenith CleanEnergy Hub Salem', latitude: 11.6645, longitude: 78.1465, address: 'NH 44 Steel Junction', city: 'Salem', pricePerKwh: 14.5, operatingStatus: 'AVAILABLE', totalChargers: 6, availableChargers: 4, chargingSpeed: 120.0, rating: 4.5, waitingTime: 0, operator: 'Zenith Energy'})
CREATE (l5)-[:HAS_STATION]->(st4);

// 6. Create Charging Points (attached to Stations)
MATCH (st1:ChargingStation {stationId: 'STN-001'})
CREATE (c1:ChargingPoint {chargerId: 'CHG-101', connectorType: 'CCS2', chargingPower: 240.0, status: 'AVAILABLE', pricePerKwh: 18.5, chargingSpeed: 240.0})
CREATE (c2:ChargingPoint {chargerId: 'CHG-102', connectorType: 'CCS2', chargingPower: 240.0, status: 'OCCUPIED', pricePerKwh: 18.5, chargingSpeed: 240.0})
CREATE (c3:ChargingPoint {chargerId: 'CHG-103', connectorType: 'Type 2', chargingPower: 22.0, status: 'AVAILABLE', pricePerKwh: 14.0, chargingSpeed: 22.0})
CREATE (st1)-[:HAS_CHARGER]->(c1)
CREATE (st1)-[:HAS_CHARGER]->(c2)
CREATE (st1)-[:HAS_CHARGER]->(c3);

// 7. Create Demand Records (attached to Stations)
MATCH (st1:ChargingStation {stationId: 'STN-001'})
CREATE (d1:DemandRecord {demandId: 'DEM-101', timestamp: '2026-09-28 08:00:00', dayOfWeek: 'Monday', hour: 8, chargingSessions: 3, energyConsumed: 75.0, demandLevel: 'LOW', waitingTime: 0})
CREATE (d2:DemandRecord {demandId: 'DEM-102', timestamp: '2026-09-28 12:00:00', dayOfWeek: 'Monday', hour: 12, chargingSessions: 9, energyConsumed: 210.0, demandLevel: 'HIGH', waitingTime: 12})
CREATE (d3:DemandRecord {demandId: 'DEM-103', timestamp: '2026-09-28 18:00:00', dayOfWeek: 'Monday', hour: 18, chargingSessions: 12, energyConsumed: 290.0, demandLevel: 'VERY HIGH', waitingTime: 24})
CREATE (st1)-[:HAS_DEMAND]->(d1)
CREATE (st1)-[:HAS_DEMAND]->(d2)
CREATE (st1)-[:HAS_DEMAND]->(d3);

// 8. Create Trips
MATCH (u1:User {userId: 'USR-8829'})
CREATE (t1:Trip {tripId: 'TRIP-9921', startLocation: 'Coimbatore Central', destination: 'Salem Steel Plaza', distance: 148.0, travelTime: 175.0, energyRequired: 23.68, chargingCost: 155.0, routeType: 'SMART_RECOMMENDED', batterySafety: 92.0, status: 'COMPLETED', createdAt: '2026-09-27 14:30:00'})
CREATE (u1)-[:PLANNED]->(t1);

// 9. Create Notifications
MATCH (u1:User {userId: 'USR-8829'})
CREATE (n1:Notification {notificationId: 'NOTIF-01', title: 'Battery State Alert', message: 'Your battery state of charge is below 20%. Automatic station recommendation suggested.', type: 'BATTERY_WARNING', isRead: false, createdAt: '2026-09-28 15:00:00'})
CREATE (n2:Notification {notificationId: 'NOTIF-02', title: 'Smart Charging Completed', message: 'Session at AeroCity Superhub completed. Added 44.2 kWh in 18 minutes.', type: 'CHARGING_COMPLETED', isRead: true, createdAt: '2026-09-27 16:20:00'})
CREATE (u1)-[:RECEIVES]->(n1)
CREATE (u1)-[:RECEIVES]->(n2);
