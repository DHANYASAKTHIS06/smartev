<?php
$pageTitle = "Charging Station Discovery";
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
                    <h1 style="font-size: 1.85rem;">Charging Station Directory</h1>
                    <p style="color: var(--text-muted);">Real-time station status, charger speed, and predicted demand forecasting</p>
                </div>
            </div>

            <!-- Search and Filter Bar -->
            <div class="card" style="margin-bottom: 2rem;">
                <form action="/stations.php" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; align-items: flex-end;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Search Location / Name</label>
                        <input type="text" name="q" class="form-control" placeholder="e.g. AeroCity, Cyber City" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Availability Status</label>
                        <select name="status" class="form-select">
                            <option value="all">All Statuses</option>
                            <option value="available">🟢 Available</option>
                            <option value="limited">🟡 Limited</option>
                            <option value="busy">🔴 Busy</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Connector Type</label>
                        <select name="connector" class="form-select">
                            <option value="all">All Connectors</option>
                            <option value="CCS2">CCS2</option>
                            <option value="Type 2">Type 2</option>
                            <option value="CHAdeMO">CHAdeMO</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Min Charging Speed</label>
                        <select name="speed" class="form-select">
                            <option value="0">Any Speed</option>
                            <option value="100">100+ kW Fast</option>
                            <option value="200">200+ kW Ultra-Fast</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" style="height: 42px;">
                        🔍 Filter Hubs
                    </button>
                </form>
            </div>

            <!-- Station Cards Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem;">
                <?php foreach ($sampleData['charging_stations'] as $stn): ?>
                    <div class="card">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
                            <div>
                                <h3 style="font-size: 1.25rem; margin-bottom: 0.2rem;"><?= htmlspecialchars($stn['name']) ?></h3>
                                <p style="font-size: 0.85rem; color: var(--text-muted);">📍 <?= htmlspecialchars($stn['location']) ?></p>
                            </div>
                            <span class="badge badge-<?= $stn['status_code'] ?>">
                                <span class="badge-dot"></span> <?= $stn['status'] ?>
                            </span>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin: 1rem 0; font-size: 0.85rem; background: var(--bg-main); padding: 1rem; border-radius: var(--radius-md);">
                            <div>
                                <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Available Ports</span>
                                <strong><?= $stn['available_chargers'] ?> / <?= $stn['total_chargers'] ?> Free</strong>
                            </div>
                            <div>
                                <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Charging Speed</span>
                                <strong style="color: var(--primary-hover);"><?= $stn['charging_speed_kw'] ?> kW</strong>
                            </div>
                            <div>
                                <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Tariff</span>
                                <strong>₹<?= $stn['price_per_kwh'] ?> / kWh</strong>
                            </div>
                            <div>
                                <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Est. Wait Time</span>
                                <strong><?= $stn['estimated_wait_min'] ?> mins</strong>
                            </div>
                            <div>
                                <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Current Demand</span>
                                <strong><?= $stn['current_demand_pct'] ?>%</strong>
                            </div>
                            <div>
                                <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Predicted Demand</span>
                                <strong style="color: #f59e0b;"><?= $stn['predicted_demand_pct'] ?>%</strong>
                            </div>
                        </div>

                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1.25rem;">
                            <?php foreach ($stn['connectors'] as $conn): ?>
                                <span class="badge badge-primary" style="font-size: 0.75rem;"><?= $conn ?></span>
                            <?php endforeach; ?>
                        </div>

                        <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid var(--border-color); padding-top: 1rem;">
                            <span style="font-size: 0.85rem; color: var(--text-muted);">📏 <?= $stn['distance_km'] ?> km away</span>
                            <a href="/station_detail.php?id=<?= $stn['id'] ?>" class="btn btn-primary btn-sm">
                                View Details & Graph
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>

        <?php require_once __DIR__ . '/includes/footer.php'; ?>
    </div>
</div>
