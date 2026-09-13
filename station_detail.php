<?php
$pageTitle = "Charging Station Details";
$sampleData = require_once __DIR__ . '/data/sample_data.php';
$station = $sampleData['charging_stations'][0];
require_once __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require_once __DIR__ . '/includes/sidebar.php'; ?>

    <div class="main-content">
        <?php require_once __DIR__ . '/includes/topbar.php'; ?>
        <?php require_once __DIR__ . '/includes/alerts.php'; ?>

        <main class="content-container">
            <div style="margin-bottom: 1.5rem;">
                <a href="/stations.php" style="color: var(--text-muted); font-size: 0.9rem;">← Back to Station Directory</a>
            </div>

            <!-- Header Card -->
            <div class="card" style="margin-bottom: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.25rem;">
                            <h1 style="font-size: 2rem; margin: 0;"><?= htmlspecialchars($station['name']) ?></h1>
                            <span class="badge badge-<?= $station['status_code'] ?>">🟢 <?= $station['status'] ?></span>
                        </div>
                        <p style="color: var(--text-muted); font-size: 0.95rem;">📍 <?= htmlspecialchars($station['location']) ?> (<?= $station['distance_km'] ?> km away)</p>
                    </div>

                    <div style="display: flex; gap: 0.75rem;">
                        <button class="btn btn-outline btn-sm" onclick="showToast('Station added to favorites!', 'success')">⭐ Add to Favorites</button>
                        <button class="btn btn-secondary btn-sm" onclick="openModal('bookStationModal')">📍 Navigate</button>
                        <button class="btn btn-primary btn-sm" onclick="openModal('bookStationModal')">⚡ Start Charging</button>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 1.25rem; background: var(--bg-main); padding: 1.5rem; border-radius: var(--radius-md);">
                    <div>
                        <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Available Ports</span>
                        <strong style="font-size: 1.25rem; color: var(--navy-dark);"><?= $station['available_chargers'] ?> / <?= $station['total_chargers'] ?> Free</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Charging Speed</span>
                        <strong style="font-size: 1.25rem; color: var(--primary-hover);"><?= $station['charging_speed_kw'] ?> kW DC</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Tariff Price</span>
                        <strong style="font-size: 1.25rem; color: var(--navy-dark);">₹<?= $station['price_per_kwh'] ?> / kWh</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Current Queue</span>
                        <strong style="font-size: 1.25rem; color: var(--navy-dark);"><?= $station['estimated_wait_min'] ?> mins wait</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Current Demand</span>
                        <strong style="font-size: 1.25rem; color: var(--navy-dark);"><?= $station['current_demand_pct'] ?>%</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Predicted Peak</span>
                        <strong style="font-size: 1.25rem; color: #f59e0b;"><?= $station['predicted_demand_pct'] ?>% at 6 PM</strong>
                    </div>
                </div>
            </div>

            <!-- "Best Time to Charge" Section -->
            <div class="card" style="margin-bottom: 2rem;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                    <div>
                        <h2 style="font-size: 1.4rem; color: var(--navy-dark);">Best Time to Charge</h2>
                        <p style="color: var(--text-muted); font-size: 0.9rem;">24-hour demand prediction chart highlighting peak congestion periods</p>
                    </div>
                    <span class="badge badge-primary">AI Time-Series Forecast</span>
                </div>

                <div style="background: var(--bg-main); padding: 1.5rem; border-radius: var(--radius-lg); border: 1px solid var(--border-color); margin-bottom: 1.5rem;">
                    <canvas id="stationDemandCanvas" style="width: 100%; height: 260px;"></canvas>
                </div>

                <div class="card-dark" style="border-radius: var(--radius-md); padding: 1.25rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <span style="font-size: 1.5rem;">💡</span>
                        <div>
                            <strong style="color: var(--primary); display: block; margin-bottom: 0.2rem;">Smart Recommendation</strong>
                            <p style="margin: 0; font-size: 0.9rem; color: var(--text-light);">
                                Demand is expected to increase significantly between <strong>6:00 PM and 7:00 PM (88% Occupancy)</strong>. Consider arriving before <strong>5:30 PM</strong> to avoid queue wait times.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php require_once __DIR__ . '/includes/modals.php'; ?>
        <?php require_once __DIR__ . '/includes/footer.php'; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const forecast = <?= json_encode($sampleData['demand_forecast']) ?>;
    renderDemandChart('stationDemandCanvas', forecast);
});
</script>
