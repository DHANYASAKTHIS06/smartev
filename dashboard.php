<?php
$pageTitle = "User Dashboard";
$sampleData = require_once __DIR__ . '/data/sample_data.php';
require_once __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require_once __DIR__ . '/includes/sidebar.php'; ?>

    <div class="main-content">
        <?php require_once __DIR__ . '/includes/topbar.php'; ?>
        <?php require_once __DIR__ . '/includes/alerts.php'; ?>

        <main class="content-container">
            <!-- Welcome Header -->
            <div class="dashboard-header">
                <div class="user-welcome">
                    <h1>Good morning, <?= htmlspecialchars($_SESSION['user']['name']) ?> 👋</h1>
                    <p>Your EV network status is optimal. All 250+ charging hubs active.</p>
                </div>
                <a href="/route_planner.php" class="btn btn-primary">
                    ⚡ New Route Search
                </a>
            </div>

            <!-- Current EV Circular Battery Widget Card -->
            <div class="battery-card" style="margin-bottom: 2rem;">
                <div class="battery-ring-container">
                    <svg class="battery-ring-svg" viewBox="0 0 120 120">
                        <circle class="battery-ring-bg" cx="60" cy="60" r="54"></circle>
                        <circle class="battery-ring-fill" cx="60" cy="60" r="54"></circle>
                    </svg>
                    <div class="battery-center-text">
                        <div class="battery-pct">68%</div>
                        <div class="battery-sub">SOC</div>
                    </div>
                </div>

                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                        <h2 style="font-size: 1.4rem; color: #ffffff; margin: 0;"><?= htmlspecialchars($_SESSION['user']['ev_model']) ?></h2>
                        <span class="badge badge-primary">Active Vehicle</span>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 1rem; background: rgba(255,255,255,0.06); padding: 1rem; border-radius: var(--radius-md);">
                        <div>
                            <span style="display: block; font-size: 0.75rem; color: var(--text-light);">Estimated Range</span>
                            <strong style="font-size: 1.25rem; font-family: var(--font-heading); color: var(--primary);">214 km</strong>
                        </div>
                        <div>
                            <span style="display: block; font-size: 0.75rem; color: var(--text-light);">Battery Capacity</span>
                            <strong style="font-size: 1.25rem; font-family: var(--font-heading); color: #ffffff;"><?= $_SESSION['user']['battery_capacity'] ?> kWh</strong>
                        </div>
                        <div>
                            <span style="display: block; font-size: 0.75rem; color: var(--text-light);">Connector Type</span>
                            <strong style="font-size: 1.1rem; font-family: var(--font-heading); color: #ffffff;"><?= $_SESSION['user']['connector_type'] ?></strong>
                        </div>
                        <div>
                            <span style="display: block; font-size: 0.75rem; color: var(--text-light);">Charging Status</span>
                            <span class="badge badge-available">🟢 Ready to Charge</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Grid -->
            <h3 style="font-size: 1.15rem; margin-bottom: 1rem;">Quick Actions</h3>
            <div class="quick-actions-grid">
                <a href="/route_planner.php" class="action-card">
                    <div class="action-icon">🗺️</div>
                    <div class="action-info">
                        <h4>Plan Journey</h4>
                        <p>Shortest-path EV routing</p>
                    </div>
                </a>

                <a href="/stations.php" class="action-card">
                    <div class="action-icon">🔌</div>
                    <div class="action-info">
                        <h4>Find Charger</h4>
                        <p>Locate fast charging hubs</p>
                    </div>
                </a>

                <a href="/calculator.php" class="action-card">
                    <div class="action-icon">💰</div>
                    <div class="action-info">
                        <h4>Charging Cost</h4>
                        <p>Energy & tariff estimator</p>
                    </div>
                </a>

                <a href="/trip_history.php" class="action-card">
                    <div class="action-icon">🕒</div>
                    <div class="action-info">
                        <h4>Trip History</h4>
                        <p>View past journey logs</p>
                    </div>
                </a>
            </div>

            <!-- Dashboard Statistics -->
            <h3 style="font-size: 1.15rem; margin-bottom: 1rem;">Dashboard Analytics</h3>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Total Trips</span>
                        <span>🛣️</span>
                    </div>
                    <div class="stat-value">28</div>
                    <div class="stat-trend">↑ 12% this month</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Total Distance</span>
                        <span>📍</span>
                    </div>
                    <div class="stat-value">3,420 km</div>
                    <div class="stat-trend">↑ 410 km week</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Energy Consumed</span>
                        <span>⚡</span>
                    </div>
                    <div class="stat-value">547 kWh</div>
                    <div class="stat-trend">0.160 kWh/km avg</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Total Charging Cost</span>
                        <span>💳</span>
                    </div>
                    <div class="stat-value">₹3,840</div>
                    <div class="stat-trend">Saved ₹4,200 vs petrol</div>
                </div>
            </div>

            <!-- Recommended Station Spotlight -->
            <h3 style="font-size: 1.15rem; margin-bottom: 1rem;">Recommended Station Near You</h3>
            <?php $topStation = $sampleData['charging_stations'][0]; ?>
            <div class="card" style="border-left: 5px solid var(--primary);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <h2 style="font-size: 1.35rem; margin: 0;"><?= htmlspecialchars($topStation['name']) ?></h2>
                            <span class="badge badge-available">🟢 <?= $topStation['status'] ?></span>
                        </div>
                        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.25rem;">
                            📍 <?= htmlspecialchars($topStation['location']) ?> (<?= $topStation['distance_km'] ?> km away)
                        </p>
                    </div>

                    <a href="/station_detail.php?id=<?= $topStation['id'] ?>" class="btn btn-primary btn-sm">
                        View Station Details
                    </a>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; background: var(--bg-main); padding: 1.25rem; border-radius: var(--radius-md);">
                    <div>
                        <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Available Chargers</span>
                        <strong style="font-size: 1.1rem; color: var(--navy-dark);"><?= $topStation['available_chargers'] ?> / <?= $topStation['total_chargers'] ?> Ports</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Charging Speed</span>
                        <strong style="font-size: 1.1rem; color: var(--primary-hover);"><?= $topStation['charging_speed_kw'] ?> kW Supercharge</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Tariff Rate</span>
                        <strong style="font-size: 1.1rem; color: var(--navy-dark);">₹<?= $topStation['price_per_kwh'] ?> / kWh</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Current Demand</span>
                        <strong style="font-size: 1.1rem; color: var(--navy-dark);"><?= $topStation['current_demand_pct'] ?>% (Low Queue)</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Predicted Demand</span>
                        <strong style="font-size: 1.1rem; color: #f59e0b;"><?= $topStation['predicted_demand_pct'] ?>% at 6 PM</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Wait Time</span>
                        <strong style="font-size: 1.1rem; color: var(--status-available);"><?= $topStation['estimated_wait_min'] ?> mins</strong>
                    </div>
                </div>
            </div>
        </main>

        <?php require_once __DIR__ . '/includes/footer.php'; ?>
    </div>
</div>
