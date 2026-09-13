<?php
$pageTitle = "Report Generation - Admin";
require_once __DIR__ . '/includes/header.php';

$reports = [
    ['title' => 'Trip Optimization Report', 'desc' => 'Comprehensive summary of graph shortest paths, trip durations, and safety reserves.', 'type' => 'Trip'],
    ['title' => 'Charging Station Utilization Report', 'desc' => 'Individual hub occupancy rates, port uptime, and revenue generation.', 'type' => 'Station'],
    ['title' => 'Energy Consumption Report', 'desc' => 'Total MWh throughput, peak hour draw, and grid load balance analysis.', 'type' => 'Energy'],
    ['title' => 'Predictive Demand Forecast Report', 'desc' => 'Historical vs AI predicted queue trends and bottleneck identification.', 'type' => 'Demand'],
    ['title' => 'Cost & Revenue Report', 'desc' => 'Financial summary of driver tariffs, station operating expenses, and margins.', 'type' => 'Cost'],
    ['title' => 'User Activity Report', 'desc' => 'Driver registration trends, EV model distribution, and active user analytics.', 'type' => 'User'],
    ['title' => 'Neo4j Network Utilization Report', 'desc' => 'Graph node density, edge weight efficiency, and Dijkstra path latency.', 'type' => 'Network']
];
?>

<div class="app-layout">
    <?php require_once __DIR__ . '/includes/admin_sidebar.php'; ?>

    <div class="main-content">
        <?php require_once __DIR__ . '/includes/topbar.php'; ?>
        <?php require_once __DIR__ . '/includes/alerts.php'; ?>

        <main class="content-container">
            <div class="dashboard-header">
                <div>
                    <h1 style="font-size: 1.85rem;">System Report Generation</h1>
                    <p style="color: var(--text-muted);">Generate, preview, and print operational reports for college evaluation & audit</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem;">
                <?php foreach ($reports as $r): ?>
                    <div class="card">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
                            <h3 style="font-size: 1.15rem; margin: 0;"><?= htmlspecialchars($r['title']) ?></h3>
                            <span class="badge badge-primary"><?= $r['type'] ?></span>
                        </div>
                        <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1.25rem;">
                            <?= htmlspecialchars($r['desc']) ?>
                        </p>

                        <div style="display: flex; gap: 0.5rem; border-top: 1px solid var(--border-color); padding-top: 1rem;">
                            <button class="btn btn-primary btn-sm" style="flex: 1;" onclick="showToast('Generating PDF Report...', 'success')">
                                📄 Generate Report
                            </button>
                            <button class="btn btn-outline btn-sm" onclick="window.print()">
                                🖨️ Print Report
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>

        <?php require_once __DIR__ . '/includes/footer.php'; ?>
    </div>
</div>
