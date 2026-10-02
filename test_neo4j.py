import sys
from neo4j import GraphDatabase

# Neo4j Aura Connection Settings
URI = "neo4j+s://355200dd.databases.neo4j.io"
USER = "neo4j"
PASSWORD = sys.argv[1] if len(sys.argv) > 1 else "dYjIauLvTPSjKPdsgM8J2fpRikZVJECCxLvlU4PwZiA"

print(f"Connecting to Neo4j AuraDB: {URI}")
print(f"User: {USER}")

try:
    with GraphDatabase.driver(URI, auth=(USER, PASSWORD)) as driver:
        driver.verify_connectivity()
        print(" SUCCESS: Successfully connected to Neo4j AuraDB!")
        
        with driver.session(database="neo4j") as session:
            # Check node count
            res = session.run("MATCH (n) RETURN count(n) AS totalNodes, count(DISTINCT labels(n)) AS labelCount")
            record = res.single()
            print(f" Current Graph State: {record['totalNodes']} Nodes present in database.")

            # List existing User and EV nodes
            user_res = session.run("MATCH (u:User) RETURN u.userId AS id, u.name AS name, u.email AS email LIMIT 5")
            users = user_res.data()
            print(f" Users in Neo4j ({len(users)}): {users}")

            ev_res = session.run("MATCH (u:User)-[:OWNS]->(ev:EV) RETURN u.name AS user, ev.model AS evModel, ev.currentBattery AS soc LIMIT 5")
            evs = ev_res.data()
            print(f" EVs in Neo4j ({len(evs)}): {evs}")

except Exception as e:
    print(f"\n❌ CONNECTION ERROR: {e}")
    print("\n💡 HOW TO FIX:")
    print("1. Open https://console.neo4j.io")
    print("2. If you reset your password, run: python test_neo4j.py YOUR_NEW_PASSWORD")
    print("3. Ensure your AuraDB instance is in 'Running' status (not Paused).")
