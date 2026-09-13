<?php
$pageTitle = "Smart Route Planner";
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
                    <h1 style="font-size: 1.85rem;">Smart EV Route Planner</h1>
                    <p style="color: var(--text-muted);">Graph shortest-path optimization with battery consumption safety reserves</p>
                </div>
            </div>

            <!-- Route Input Form -->
            <div class="card" style="margin-bottom: 2rem;">
                <form id="routePlannerForm">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem; margin-bottom: 1.25rem;">
                        <div class="form-group">
                            <label class="form-label">📍 Current Location</label>
                            <input type="text" id="originInput" class="form-control" value="Downtown Central Plaza" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">🏁 Destination</label>
                            <input type="text" id="destInput" class="form-control" value="Tech Hub East" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">🔋 Current Battery % (SOC)</label>
                            <input type="number" id="batteryInput" class="form-control" value="68" min="5" max="100" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">🚘 Select EV Profile</label>
                            <select class="form-select">
                                <?php foreach ($sampleData['user_evs'] as $ev): ?>
                                    <option value="<?= $ev['id'] ?>"><?= htmlspecialchars($ev['model']) ?> (<?= $ev['battery_capacity'] ?> kWh)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">🎯 Route Preference</label>
                            <select class="form-select" id="prefInput">
                                <option value="smart" selected>Smart Recommended ⭐</option>
                                <option value="fastest">Fastest Travel Time</option>
                                <option value="cheapest">Cheapest Charging Cost</option>
                                <option value="shortest">Shortest Distance</option>
                                <option value="safest">Safest Battery Margin</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                        ⚡ Find Best Route (Execute Cypher Query)
                    </button>
                </form>
            </div>

            <!-- Route Result Section -->
            <div id="routeResultsSection">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                    <h2 style="font-size: 1.4rem;">Optimized Route Options</h2>
                    <span class="badge badge-primary">3 Cypher Graph Paths Found</span>
                </div>

                <div class="routes-grid">
                    <!-- FASTEST ROUTE -->
                    <div class="route-card" id="route_fastest">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3 style="font-size: 1.15rem; color: var(--navy-dark);">FASTEST ROUTE</h3>
                            <span class="badge badge-limited">Fastest Time</span>
                        </div>

                        <div class="route-meta">
                            <div class="meta-item">
                                <span class="meta-label">Distance</span>
                                <span class="meta-val">145 km</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Travel Time</span>
                                <span class="meta-val">2h 48m</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Charging Stops</span>
                                <span class="meta-val">1 Stop</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Charging Cost</span>
                                <span class="meta-val">₹185</span>
                            </div>
                        </div>

                        <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.25rem;">
                            📍 Stop at <strong>EcoPulse Metro Park Hub</strong> (150 kW Charger)
                        </div>

                        <button class="btn btn-outline btn-sm" style="width: 100%;" onclick="selectRoute('route_fastest')">Select Fastest Route</button>
                    </div>

                    <!-- CHEAPEST ROUTE -->
                    <div class="route-card" id="route_cheapest">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h3 style="font-size: 1.15rem; color: var(--navy-dark);">CHEAPEST ROUTE</h3>
                            <span class="badge badge-available">Best Value</span>
                        </div>

                        <div class="route-meta">
                            <div class="meta-item">
                                <span class="meta-label">Distance</span>
                                <span class="meta-val">151 km</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Travel Time</span>
                                <span class="meta-val">3h 05m</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Charging Stops</span>
                                <span class="meta-val">1 Stop</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Charging Cost</span>
                                <span class="meta-val">₹142</span>
                            </div>
                        </div>

                        <div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.25rem;">
                            📍 Stop at <strong>Zenith CleanEnergy Hub</strong> (₹12.8 / kWh)
                        </div>

                        <button class="btn btn-outline btn-sm" style="width: 100%;" onclick="selectRoute('route_cheapest')">Select Cheapest Route</button>
                    </div>

                    <!-- SMART RECOMMENDED ROUTE ⭐ -->
                    <div class="route-card route-card-recommended" id="route_smart">
                        <span class="route-badge">SMART RECOMMENDED ⭐</span>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
                            <h3 style="font-size: 1.2rem; color: var(--navy-dark);">SMART ROUTE</h3>
                            <span class="badge badge-available">92% Safety</span>
                        </div>

                        <div class="route-meta" style="background: rgba(0, 209, 118, 0.08);">
                            <div class="meta-item">
                                <span class="meta-label">Distance</span>
                                <span class="meta-val" style="color: var(--navy-dark);">148 km</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Travel Time</span>
                                <span class="meta-val" style="color: var(--navy-dark);">2h 55m</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Charging Stops</span>
                                <span class="meta-val" style="color: var(--navy-dark);">1 Stop</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Charging Cost</span>
                                <span class="meta-val" style="color: var(--primary-hover);">₹155</span>
                            </div>
                        </div>

                        <div style="background: #ffffff; padding: 0.85rem; border-radius: var(--radius-md); border: 1px solid rgba(0,209,118,0.3); margin-bottom: 1.25rem; font-size: 0.875rem;">
                            <div style="font-weight: 700; color: var(--navy-dark); margin-bottom: 0.2rem;">🛡️ Battery Safety Margin: 92%</div>
                            <div style="color: var(--text-muted);">Stop at <strong>AeroCity HyperCharge Superhub</strong> (240 kW • Zero Queue Time)</div>
                        </div>

                        <button class="btn btn-primary btn-sm" style="width: 100%; font-weight: 700;" onclick="selectRoute('route_smart')">
                            ⚡ Navigate Smart Route
                        </button>
                    </div>
                </div>
            </div>
        </main>

        <?php require_once __DIR__ . '/includes/footer.php'; ?>
    </div>
</div>
