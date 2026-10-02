/**
 * Neo4j AuraDB Direct Client Engine
 * Runs official Neo4j JavaScript Bolt driver over WebSockets in browser
 * Performs live CRUD on :User and :EV nodes and relationships
 */

window.Neo4jClient = {
    driver: null,
    uri: 'neo4j+s://355200dd.databases.neo4j.io',
    user: 'neo4j',
    password: localStorage.getItem('smartev_neo4j_pass') || 'dYjIauLvTPSjKPdsgM8J2fpRikZVJECCxLvlU4PwZiA',
    database: 'neo4j',

    init: function() {
        if (typeof neo4j === 'undefined') {
            console.warn('neo4j-driver CDN not yet loaded.');
            return null;
        }
        try {
            if (!this.driver) {
                this.driver = neo4j.driver(this.uri, neo4j.auth.basic(this.user, this.password));
            }
            return this.driver;
        } catch(e) {
            console.error('Neo4j Driver Init Error:', e);
            return null;
        }
    },

    setCredentials: function(newPassword) {
        this.password = newPassword;
        localStorage.setItem('smartev_neo4j_pass', newPassword);
        if (this.driver) {
            this.driver.close();
            this.driver = null;
        }
        this.init();
    },

    runCypher: async function(query, params = {}) {
        const driver = this.init();
        if (!driver) {
            throw new Error('Neo4j driver not initialized');
        }

        const session = driver.session({ database: this.database });
        try {
            const result = await session.run(query, params);
            return result.records.map(r => r.toObject());
        } finally {
            await session.close();
        }
    },

    // 1. Create User & EV Node in Neo4j
    registerUserAndEV: async function(userData, evData) {
        const query = `
            MERGE (u:User {email: $email})
            ON CREATE SET 
                u.userId = $userId,
                u.name = $name,
                u.phone = $phone,
                u.role = 'USER',
                u.status = 'ACTIVE',
                u.createdAt = datetime()
            CREATE (ev:EV {
                evId: $evId,
                model: $model,
                batteryCapacity: toFloat($capacity),
                currentBattery: toFloat($soc),
                connectorType: $connector,
                maxChargingPower: toFloat($maxPower),
                efficiency: toFloat($efficiency),
                registrationNumber: $reg,
                createdAt: datetime()
            })
            MERGE (u)-[:OWNS]->(ev)
            RETURN u, ev;
        `;

        const params = {
            userId: userData.userId || ('USR-' + Math.random().toString(36).substr(2, 8).toUpperCase()),
            name: userData.name,
            email: userData.email.toLowerCase().trim(),
            phone: userData.phone || '',
            evId: 'EV-' + Math.random().toString(36).substr(2, 8).toUpperCase(),
            model: evData.model || 'Tata Nexon EV Max',
            capacity: parseFloat(evData.capacity || 40.5),
            soc: parseFloat(evData.soc || 75.0),
            connector: evData.connector || 'CCS2',
            maxPower: parseFloat(evData.maxPower || 50.0),
            efficiency: parseFloat(evData.efficiency || 0.14),
            reg: evData.reg || ('TN-38-' + Math.random().toString(36).substr(2, 4).toUpperCase())
        };

        return await this.runCypher(query, params);
    },

    // 2. Fetch User's EVs from Neo4j
    getUserEVs: async function(email) {
        const query = `
            MATCH (u:User {email: $email})-[:OWNS]->(ev:EV)
            RETURN ev.evId AS evId, ev.model AS model, ev.batteryCapacity AS batteryCapacity,
                   ev.currentBattery AS currentBattery, ev.connectorType AS connectorType,
                   ev.maxChargingPower AS maxChargingPower, ev.efficiency AS efficiency,
                   ev.registrationNumber AS registrationNumber
            ORDER BY ev.createdAt DESC;
        `;
        return await this.runCypher(query, { email: email.toLowerCase().trim() });
    },

    // 3. Add EV to User in Neo4j
    addEVToUser: async function(email, evData) {
        const query = `
            MATCH (u:User {email: $email})
            CREATE (ev:EV {
                evId: $evId,
                model: $model,
                batteryCapacity: toFloat($capacity),
                currentBattery: toFloat($soc),
                connectorType: $connector,
                maxChargingPower: toFloat($maxPower),
                efficiency: toFloat($efficiency),
                registrationNumber: $reg,
                createdAt: datetime()
            })
            CREATE (u)-[:OWNS]->(ev)
            RETURN ev;
        `;

        const params = {
            email: email.toLowerCase().trim(),
            evId: 'EV-' + Math.random().toString(36).substr(2, 8).toUpperCase(),
            model: evData.model,
            capacity: parseFloat(evData.capacity || 40.5),
            soc: parseFloat(evData.soc || 80.0),
            connector: evData.connector || 'CCS2',
            maxPower: parseFloat(evData.maxPower || 50.0),
            efficiency: parseFloat(evData.efficiency || 0.14),
            reg: evData.reg || ('TN-38-' + Math.random().toString(36).substr(2, 4).toUpperCase())
        };

        return await this.runCypher(query, params);
    },

    // 4. Update EV Node in Neo4j
    updateEVNode: async function(evId, evData) {
        const query = `
            MATCH (ev:EV {evId: $evId})
            SET ev.model = $model,
                ev.batteryCapacity = toFloat($capacity),
                ev.currentBattery = toFloat($soc),
                ev.connectorType = $connector,
                ev.maxChargingPower = toFloat($maxPower),
                ev.registrationNumber = $reg,
                ev.updatedAt = datetime()
            RETURN ev;
        `;

        const params = {
            evId: evId,
            model: evData.model,
            capacity: parseFloat(evData.capacity),
            soc: parseFloat(evData.soc),
            connector: evData.connector,
            maxPower: parseFloat(evData.maxPower),
            reg: evData.reg
        };

        return await this.runCypher(query, params);
    },

    // 5. Delete EV Node from Neo4j
    deleteEVNode: async function(evId) {
        const query = `
            MATCH (ev:EV {evId: $evId})
            DETACH DELETE ev;
        `;
        return await this.runCypher(query, { evId: evId });
    }
};
