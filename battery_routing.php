<?php
$pageTitle = "Battery-Aware Routing";
$sampleData = require_once __DIR__ . '/data/sample_data.php';
require_once __DIR__ . '/includes/header.php';

$simulatedSoc = intval($_GET['soc'] ?? 68);
$isWarningState = ($simulatedSoc < 30);
?>

<div class="app-layout">
    <?php require_once __DIR__ . '/includes/sidebar.php'; ?>

    <div class="main-content">
        <?php require_once __DIR__ . '/includes/topbar.php'; ?>
        <?php require_once __DIR__ . '/includes/alerts.php'; ?>

        <main class="content-container">
            <div class="dashboard-header">
                <div>
                    <h1 style="font-size: 1.85rem;">Battery-Aware Journey Analysis</h1>
                    <p style="color: var(--text-muted);">Real-time State of Charge (SOC) tracking and safety margin evaluation</p>
                </div>

                <div style="display: flex; gap: 0.5rem;">
                    <a href="/battery_routing.php?soc=68" class="btn btn-outline btn-sm <?= $simulatedSoc == 68 ? 'btn-primary' : '' ?>">Normal Battery (68%)</a>
                    <a href="/battery_routing.php?soc=22" class="btn btn-outline btn-sm <?= $simulatedSoc == 22 ? 'btn-primary' : '' ?>" style="color: #ef4444;">Simulate Low Battery (22%)</a>
                </div>
            </div>

            <!-- Prominent Warning Banner if Battery is Insufficient -->
            <?php if ($isWarningState): ?>
                <div class="card" style="border-left: 6px solid #ef4444; background: #fff5f5; margin-bottom: 2rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <span style="font-size: 2.5rem;">🚨</span>
                        <div style="flex: 1;">
                            <h3 style="color: #991b1b; font-size: 1.25rem; margin-bottom: 0.25rem;">
                                Your current battery is insufficient to reach the destination.
                            </h3>
                            <p style="color: #7f1d1d; font-size: 0.925rem; margin: 0;">
                                Remaining range (71 km) is less than trip distance (148 km). The graph algorithm has automatically inserted a charging stop.
                            </p>
                        </div>
                        <a href="#suggestedStations" class="btn btn-secondary btn-sm" style="background: #991b1b; color: #ffffff;">View En-Route Chargers</a>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Visual Battery Journey Flow Stepper -->
            <div class="card" style="margin-bottom: 2rem;">
                <h3 style="font-size: 1.2rem; margin-bottom: 1.5rem;">Journey Battery Discharge Flow</h3>

                <div class="journey-stepper">
                    <!-- Step 1: Start -->
                    <div style="text-align: center;">
                        <div class="journey-step" style="border-color: var(--primary);">
                            <?= $simulatedSoc ?>%
                        </div>
                        <div class="journey-step-info">
                            <strong>Origin</strong>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">Downtown Central</div>
                        </div>
                    </div>

                    <!-- Step 2: Consumption drop -->
                    <div style="text-align: center;">
                        <div class="journey-step" style="border-color: #f59e0b;">
                            <?= max(5, $simulatedSoc - 26) ?>%
                        </div>
                        <div class="journey-step-info">
                            <strong>Arrival at Hub</strong>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">-26% Consumption</div>
                        </div>
                    </div>

                    <!-- Step 3: Fast Charge -->
                    <div style="text-align: center;">
                        <div class="journey-step" style="background: var(--primary-light); border-color: var(--primary);">
                            ⚡ 85%
                        </div>
                        <div class="journey-step-info">
                            <strong>Charging Stop</strong>
                            <div style="font-size: 0.8rem; color: var(--primary-hover);">AeroCity Hub (+59%)</div>
                        </div>
                    </div>

                    <!-- Step 4: Destination Arrival -->
                    <div style="text-align: center;">
                        <div class="journey-step" style="border-color: #3b82f6;">
                            58%
                        </div>
                        <div class="journey-step-info">
                            <strong>Destination</strong>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">Tech Hub East</div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Battery Metrics -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 2rem; background: var(--bg-main); padding: 1.25rem; border-radius: var(--radius-md);">
                    <div>
                        <span style="font-size: 0.8rem; color: var(--text-muted); display: block;">Total Trip Distance</span>
                        <strong style="font-size: 1.2rem;">148 km</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.8rem; color: var(--text-muted); display: block;">Estimated Consumption</span>
                        <strong style="font-size: 1.2rem; color: var(--navy-dark);">23.6 kWh</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.8rem; color: var(--text-muted); display: block;">Remaining Battery Reserve</span>
                        <strong style="font-size: 1.2rem; color: var(--primary-hover);">58% SOC</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.8rem; color: var(--text-muted); display: block;">Required Charging Amount</span>
                        <strong style="font-size: 1.2rem;">44.2 kWh (18 mins)</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.8rem; color: var(--text-muted); display: block;">Safety Margin Guarantee</span>
                        <span class="badge badge-available">92% Optimal Reserve</span>
                    </div>
                </div>
            </div>

            <!-- Automatically Suggested Charging Stations -->
            <div id="suggestedStations">
                <h3 style="font-size: 1.2rem; margin-bottom: 1rem;">Suggested En-Route Charging Hubs</h3>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                    <?php foreach (array_slice($sampleData['charging_stations'], 0, 2) as $stn): ?>
                        <div class="card">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                                <h4 style="font-size: 1.1rem; margin: 0;"><?= htmlspecialchars($stn['name']) ?></h4>
                                <span class="badge badge-available">🟢 Available</span>
                            </div>
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem;">
                                📍 <?= htmlspecialchars($stn['location']) ?> • <?= $stn['distance_km'] ?> km away
                            </p>
                            <div style="display: flex; justify-content: space-between; font-size: 0.85rem; background: var(--bg-main); padding: 0.75rem; border-radius: var(--radius-sm); margin-bottom: 1rem;">
                                <span>Speed: <strong><?= $stn['charging_speed_kw'] ?> kW</strong></span>
                                <span>Price: <strong>₹<?= $stn['price_per_kwh'] ?>/kWh</strong></span>
                            </div>
                            <a href="/station_detail.php?id=<?= $stn['id'] ?>" class="btn btn-primary btn-sm" style="width: 100%;">Add Stop to Journey</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>

        <?php require_once __DIR__ . '/includes/footer.php'; ?>
    </div>
</div>
