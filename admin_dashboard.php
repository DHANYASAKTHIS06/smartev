<?php
$pageTitle = "Admin Dashboard";
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
                    <h1 style="font-size: 1.85rem;">System Administration Dashboard</h1>
                    <p style="color: var(--text-muted);">Neo4j EV Network Management & Charging Demand Analytics</p>
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    <a href="/admin_reports.php" class="btn btn-outline btn-sm">📄 Generate System Reports</a>
                    <a href="/admin_road_network.php" class="btn btn-primary btn-sm">🛣️ Graph Topology Admin</a>
                </div>
            </div>

            <!-- Admin Overview Key Metrics Cards -->
            <div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); margin-bottom: 2rem;">
                <div class="stat-card">
                    <span class="stat-title">Total Users</span>
                    <div class="stat-value">1,420</div>
                    <div class="stat-trend">↑ 48 this week</div>
                </div>

                <div class="stat-card">
                    <span class="stat-title">Registered EVs</span>
                    <div class="stat-value">1,890</div>
                    <div class="stat-trend">Tesla / Tata / Hyundai</div>
                </div>

                <div class="stat-card">
                    <span class="stat-title">Charging Stations</span>
                    <div class="stat-value">250</div>
                    <div class="stat-trend">98% Operational</div>
                </div>

                <div class="stat-card">
                    <span class="stat-title">Charging Points</span>
                    <div class="stat-value">850</div>
                    <div class="stat-trend">640 Available Now</div>
                </div>

                <div class="stat-card">
                    <span class="stat-title">Active Trips</span>
                    <div class="stat-value">142</div>
                    <div class="stat-trend">Live En-Route</div>
                </div>

                <div class="stat-card">
                    <span class="stat-title">Today's Sessions</span>
                    <div class="stat-value">620</div>
                    <div class="stat-trend">Avg 22 min charge</div>
                </div>

                <div class="stat-card" style="border-left: 4px solid var(--primary);">
                    <span class="stat-title">Total Energy Consumed</span>
                    <div class="stat-value">18.4 MWh</div>
                    <div class="stat-trend">⚡ Today's throughput</div>
                </div>
            </div>

            <!-- Admin Analytics Charts Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;" class="admin-chart-grid">
                <!-- Daily Charging Sessions & Demand Chart -->
                <div class="card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <h3 style="font-size: 1.15rem;">Daily Charging Demand & Station Utilization</h3>
                        <span class="badge badge-primary">Real-time Feed</span>
                    </div>

                    <div style="background: var(--bg-main); padding: 1rem; border-radius: var(--radius-md);">
                        <canvas id="adminDemandCanvas" style="width: 100%; height: 240px;"></canvas>
                    </div>
                </div>

                <!-- Peak Hours & Network Health -->
                <div class="card">
                    <h3 style="font-size: 1.15rem; margin-bottom: 1rem;">Peak Hours & Utilization Summary</h3>

                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <div style="background: var(--bg-main); padding: 1rem; border-radius: var(--radius-md);">
                            <div style="display: flex; justify-content: space-between; font-weight: 600; font-size: 0.9rem; margin-bottom: 0.35rem;">
                                <span>Morning Peak (8:00 AM - 10:30 AM)</span>
                                <span style="color: #f59e0b;">68% Capacity</span>
                            </div>
                            <div style="height: 8px; background: var(--border-color); border-radius: 4px; overflow: hidden;">
                                <div style="width: 68%; height: 100%; background: #f59e0b;"></div>
                            </div>
                        </div>

                        <div style="background: var(--bg-main); padding: 1rem; border-radius: var(--radius-md);">
                            <div style="display: flex; justify-content: space-between; font-weight: 600; font-size: 0.9rem; margin-bottom: 0.35rem;">
                                <span>Evening Peak (6:00 PM - 8:30 PM)</span>
                                <span style="color: #ef4444;">91% High Congestion</span>
                            </div>
                            <div style="height: 8px; background: var(--border-color); border-radius: 4px; overflow: hidden;">
                                <div style="width: 91%; height: 100%; background: #ef4444;"></div>
                            </div>
                        </div>

                        <div style="background: var(--bg-main); padding: 1rem; border-radius: var(--radius-md);">
                            <div style="display: flex; justify-content: space-between; font-weight: 600; font-size: 0.9rem; margin-bottom: 0.35rem;">
                                <span>Off-Peak (11:00 PM - 6:00 AM)</span>
                                <span style="color: var(--primary-hover);">24% Optimal</span>
                            </div>
                            <div style="height: 8px; background: var(--border-color); border-radius: 4px; overflow: hidden;">
                                <div style="width: 24%; height: 100%; background: var(--primary);"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php require_once __DIR__ . '/includes/footer.php'; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const forecast = <?= json_encode($sampleData['demand_forecast']) ?>;
    renderDemandChart('adminDemandCanvas', forecast);
});
</script>
