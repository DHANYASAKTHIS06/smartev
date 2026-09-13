<?php
$pageTitle = "Neo4j Graph Network Management - Admin";
$sampleData = require_once __DIR__ . '/data/sample_data.php';
require_once __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require_once __DIR__ . '/includes/admin_sidebar.php'; ?>

    <div class="main-content">
        <?php require_once __DIR__ . '/includes/topbar.php'; ?>
        <?php require_once __DIR__ . '/includes/alerts.php'; ?>

        <main class="content-container">
            <div class="dashboard-header">
                <div>
                    <h1 style="font-size: 1.85rem;">Neo4j Graph Topology & Road Network</h1>
                    <p style="color: var(--text-muted);">Manage location nodes, road relationship edges, distances, and Cypher edge weights</p>
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    <button class="btn btn-outline btn-sm" onclick="showToast('Add Location Node', 'info')">➕ Add Location Node</button>
                    <button class="btn btn-primary btn-sm" onclick="showToast('Add Road Edge', 'info')">🛣️ Connect Road Edge</button>
                </div>
            </div>

            <!-- Graph Canvas Explorer -->
            <div class="graph-container" style="margin-bottom: 2rem;">
                <div class="graph-controls">
                    <div class="graph-legend">
                        <div class="legend-item"><span class="legend-dot dot-location"></span> :Location Node</div>
                        <div class="legend-item"><span class="legend-dot dot-road"></span> :Road Edge</div>
                        <div class="legend-item"><span class="legend-dot dot-station"></span> :ChargingStation</div>
                    </div>
                    <span class="badge badge-primary">Cypher GDS Active</span>
                </div>
                <div class="graph-canvas-wrapper">
                    <canvas id="adminGraphCanvas"></canvas>
                </div>
            </div>

            <!-- Road Edges Table Management -->
            <div class="card">
                <h3 style="font-size: 1.2rem; margin-bottom: 1rem;">Active Road Network Edges</h3>
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Edge Relationship</th>
                                <th>Source Node</th>
                                <th>Target Node</th>
                                <th>Distance (km)</th>
                                <th>Est. Travel Time</th>
                                <th>Edge Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code style="color: var(--primary-hover);">:CONNECTED_TO</code></td>
                                <td>Downtown Central Plaza</td>
                                <td>AeroCity Hub</td>
                                <td>42.5 km</td>
                                <td>38 mins</td>
                                <td><span class="badge badge-available">🟢 Enabled</span></td>
                                <td>
                                    <button class="btn btn-outline btn-sm" onclick="showToast('Update edge properties', 'info')">✏️ Edit</button>
                                    <button class="btn btn-outline btn-sm" style="color: #ef4444;" onclick="showToast('Road edge disabled!', 'danger')">Disable</button>
                                </td>
                            </tr>
                            <tr>
                                <td><code style="color: var(--primary-hover);">:CONNECTED_TO</code></td>
                                <td>AeroCity Hub</td>
                                <td>Tech Hub East</td>
                                <td>105.5 km</td>
                                <td>1h 17m</td>
                                <td><span class="badge badge-available">🟢 Enabled</span></td>
                                <td>
                                    <button class="btn btn-outline btn-sm" onclick="showToast('Update edge properties', 'info')">✏️ Edit</button>
                                    <button class="btn btn-outline btn-sm" style="color: #ef4444;" onclick="showToast('Road edge disabled!', 'danger')">Disable</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <?php require_once __DIR__ . '/includes/footer.php'; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    window.adminGraph = new Neo4jGraphVisualizer('adminGraphCanvas');
});
</script>
