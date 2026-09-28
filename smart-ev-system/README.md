# Smart EV Charging Network Route Optimization and Predictive Demand Management Using PHP and Neo4j

An advanced graph-based Electric Vehicle (EV) journey planning, battery awareness, predictive charging demand forecasting, dynamic route replanning, and graph topology visualization platform.

---

## 🌟 Architecture & Overview

```
FRONTEND (Vercel)
    ↓  (JSON HTTP Requests)
PHP API / CONTROLLERS (Render)
    ↓
PHP SERVICES (RouteOptimization, Battery, DemandPrediction, Cost, StationRecommendation)
    ↓
CORE NEO4J CONNECTION (HTTP / HTTPS Transactional & Bolt Client)
    ↓
NEO4J AURADB CLOUD INSTANCE (neo4j+s://355200dd.databases.neo4j.io)
```

---

## 🛠️ Technology Stack

- **Backend Application Layer**: Core PHP 8+ (No heavy frameworks, object-oriented PSR-4 modular architecture).
- **Database Engine**: Neo4j AuraDB Cloud (Graph Database with Cypher query language).
- **Database Connection**: Native Neo4j HTTP Transactional API / `laudis/neo4j-php-client`.
- **Deployment Targets**: Backend on **Render**, Frontend on **Vercel**.

---

## 🌐 Neo4j Graph Data Model (10 Main Node Types)

1. **User**: `(User)-[:OWNS]->(EV)`, `(User)-[:PLANNED]->(Trip)`, `(User)-[:RECEIVES]->(Notification)`
2. **EV**: `(EV)-[:LOCATED_AT]->(Location)`, `(EV)-[:HAS_SESSION]->(ChargingSession)`
3. **Location**: Connected nodes representing cities and highway junctions across South India (Coimbatore, Tiruppur, Erode, Salem, Ooty, Mettupalayam, etc.).
4. **Road**: Directional weighted edges `(Location)-[:CONNECTED_TO {distance, travelTime, trafficLevel, energyCost}]->(Location)`.
5. **ChargingStation**: `(Location)-[:HAS_STATION]->(ChargingStation)`
6. **ChargingPoint**: `(ChargingStation)-[:HAS_CHARGER]->(ChargingPoint)`
7. **Trip**: `(User)-[:PLANNED]->(Trip)`
8. **ChargingSession**: `(EV)-[:HAS_SESSION]->(ChargingSession)-[:AT_STATION]->(ChargingStation)`
9. **DemandRecord**: `(ChargingStation)-[:HAS_DEMAND]->(DemandRecord)`
10. **Notification**: `(User)-[:RECEIVES]->(Notification)`

---

## 🚀 Setup & Execution Guide

### STEP 1: Environment Configuration

Create a `.env` file in the backend root directory (do NOT commit secrets to Git):

```env
APP_ENV=production
APP_DEBUG=true

NEO4J_URI=neo4j+s://355200dd.databases.neo4j.io
NEO4J_HTTP_URI=https://355200dd.databases.neo4j.io
NEO4J_USERNAME=neo4j
NEO4J_PASSWORD=dYjIauLvTPSjKPdsgM8J2fpRikZVJECCxLvlU4PwZiA
NEO4J_DATABASE=neo4j
```

### STEP 2: Database Initialization (Neo4j Aura Workspace)

Open your Neo4j AuraDB Browser / Workspace Query tab (`https://workspace-preview.neo4j.io/workspace/query`) and execute the Cypher scripts in **database/** in this exact order:

1. **`database/constraints.cypher`** – Creates unique index constraints for `userId`, `evId`, `stationId`, `locationId`, etc.
2. **`database/indexes.cypher`** – Creates property search indexes for fast lookup.
3. **`database/schema.cypher`** – Visualizes relationship graph schemas.
4. **`database/seed.cypher`** – Inserts 10 Users, 15 EVs, 20 Locations around Tamil Nadu/South India, 30 Road edges, 15 Charging Stations, 40 Charging Points, 50 Trips, 100 Sessions, 200 Demand Records, 30 Notifications.
5. **`database/test_queries.cypher`** – Demonstrates shortest path traversals, station scoring, and demand analytics.

### STEP 3: Test Neo4j Aura Connection

To verify that your PHP backend successfully connects to Neo4j AuraDB, run:

```bash
php test_connection.php
```

Expected Output:
```
Neo4j Connection: SUCCESS
Database: Connected
AuraDB Target: neo4j+s://355200dd.databases.neo4j.io
Status: READY FOR QUERY OPERATIONS
```

Check JSON health diagnostic endpoint:
```bash
php health.php
```

### STEP 4: Start Local Server / Deploy to Render

To run locally:
```bash
php -S localhost:8000 -t public
```

To deploy backend to **Render**:
1. Create a **New Web Service** on Render pointing to this GitHub repository.
2. Select Runtime: **PHP**.
3. Set Build Command: `composer install` (or leave empty).
4. Set Start Command: `php -S 0.0.0.0:$PORT -t public/`
5. Add Environment Variables in Render Dashboard (`NEO4J_URI`, `NEO4J_HTTP_URI`, `NEO4J_USERNAME`, `NEO4J_PASSWORD`, `NEO4J_DATABASE`).

---

## 📡 Key REST API Endpoints

| HTTP Method | Endpoint | Description |
|---|---|---|
| `POST` | `/api/auth/register` | User Registration |
| `POST` | `/api/auth/login` | User Authentication |
| `GET` | `/api/ev` | Retrieve User EVs |
| `POST` | `/api/ev` | Add EV Model Profile |
| `PUT` | `/api/ev/{id}/battery` | Update EV Battery SOC % |
| `POST` | `/api/routes/calculate` | Compute Smart Recommended EV Route & Alternatives |
| `POST` | `/api/routes/recommend` | Recommend Optimal En-Route Charging Hubs |
| `POST` | `/api/routes/recalculate` | Dynamic Rerouting on Grid Disruption |
| `GET` | `/api/stations` | Search & Filter Charging Hubs |
| `GET` | `/api/demand/predict` | 24-Hour AI Predictive Demand Forecast |
| `GET` | `/api/trips` | Retrieve Logged Journey Trips |
| `GET` | `/api/admin/dashboard` | Admin System Telemetry Stats |
| `GET` | `/api/graph` | JSON Nodes & Edges for Graph Visualizers |
