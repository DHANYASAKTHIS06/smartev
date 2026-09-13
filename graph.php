<?php
$pageTitle = "Neo4j EV Network Graph Visualization";
$sampleData = require_once __DIR__ . '/data/sample_data.php';
require_once __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require_once __DIR__ . '/includes/sidebar.php'; ?>

    <div class="main-content">
        <?php require_once __DIR__ . '/includes/topbar.php'; ?>
        <?php require_once __DIR__ . '/includes/alerts.php'; ?>

        <main class="content-container">
            <div class="dashboard-header">
                <div>
                    <div class="badge badge-primary" style="margin-bottom: 0.5rem;">Powered by Neo4j Graph Network</div>
                    <h1 style="font-size: 1.85rem;">EV Network Graph Explorer</h1>
                    <p style="color: var(--text-muted);">Visual representation of Cypher graph nodes, road edges, charging hubs, and vehicle relationships</p>
                </div>

                <div style="display: flex; gap: 0.75rem;">
                    <button class="btn btn-outline btn-sm" onclick="window.graphViz.loadSampleGraph()">🔄 Reset Canvas</button>
                    <button class="btn btn-primary btn-sm" onclick="showToast('Executing Cypher MATCH query...', 'info')">⚡ Run Shortest-Path Cypher</button>
                </div>
            </div>

            <!-- Graph Canvas Container -->
            <div class="graph-container" style="margin-bottom: 2rem;">
                <div class="graph-controls">
                    <div class="graph-legend">
                        <div class="legend-item"><span class="legend-dot dot-ev"></span> :EV</div>
                        <div class="legend-item"><span class="legend-dot dot-location"></span> :Location</div>
                        <div class="legend-item"><span class="legend-dot dot-road"></span> :Road</div>
                        <div class="legend-item"><span class="legend-dot dot-station"></span> :ChargingStation</div>
                        <div class="legend-item"><span class="legend-dot dot-point"></span> :ChargingPoint</div>
                    </div>

                    <div style="font-size: 0.85rem; color: var(--text-light);">
                        💡 Drag nodes to interactively inspect relationships
                    </div>
                </div>

                <div class="graph-canvas-wrapper">
                    <canvas id="neo4jCanvas"></canvas>
                </div>

                <!-- Cypher Code Block Display -->
                <div class="cypher-code-block">
                    <span class="cypher-keyword">MATCH</span> (ev:<span class="cypher-label">EV</span> {id: <span style="color:#ce9178;">'EV-101'</span>})-[r1:<span class="cypher-rel">LOCATED_AT</span>]->(start:<span class="cypher-label">Location</span>)<br>
                    <span class="cypher-keyword">MATCH</span> (end:<span class="cypher-label">Location</span> {name: <span style="color:#ce9178;">'Tech Hub East'</span>})<br>
                    <span class="cypher-keyword">CALL</span> gds.shortestPath.dijkstra.stream({<br>
                    &nbsp;&nbsp;nodeProjection: [<span style="color:#ce9178;">'Location'</span>, <span style="color:#ce9178;">'ChargingStation'</span>],<br>
                    &nbsp;&nbsp;relationshipProjection: <span style="color:#ce9178;">'CONNECTED_TO'</span>,<br>
                    &nbsp;&nbsp;relationshipWeightProperty: <span style="color:#ce9178;">'energyRequired'</span><br>
                    })<br>
                    <span class="cypher-keyword">YIELD</span> path, totalCost <span class="cypher-keyword">RETURN</span> path, totalCost;
                </div>
            </div>

            <!-- Why Graph Database Explanation Cards -->
            <h2 style="font-size: 1.3rem; margin-bottom: 1rem;">Why Neo4j Graph Engine is Used</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                <div class="card">
                    <h3 style="font-size: 1.15rem; margin-bottom: 0.5rem; color: var(--navy-dark);">⚡ Sub-Millisecond Traversal</h3>
                    <p style="font-size: 0.9rem; color: var(--text-muted);">
                        Relational SQL databases require expensive multi-table JOINs to calculate route multi-hops. Neo4j graph relationships allow index-free adjacency for instant route recalculation.
                    </p>
                </div>

                <div class="card">
                    <h3 style="font-size: 1.15rem; margin-bottom: 0.5rem; color: var(--navy-dark);">🔋 Multi-Constraint Shortest Path</h3>
                    <p style="font-size: 0.9rem; color: var(--text-muted);">
                        Calculates optimal paths dynamically factoring in distance, battery State of Charge (SOC), charger connector compatibility, and real-time station queue forecasts.
                    </p>
                </div>

                <div class="card">
                    <h3 style="font-size: 1.15rem; margin-bottom: 0.5rem; color: var(--navy-dark);">🌐 Dynamic Network Adaptation</h3>
                    <p style="font-size: 0.9rem; color: var(--text-muted);">
                        If a station grid breaks down, Cypher queries instantly update edge weights and reroute vehicle nodes around disrupted locations seamlessly.
                    </p>
                </div>
            </div>
        </main>

        <?php require_once __DIR__ . '/includes/footer.php'; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    window.graphViz = new Neo4jGraphVisualizer('neo4jCanvas');
});
</script>
