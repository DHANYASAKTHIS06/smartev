<?php
$pageTitle = "Dynamic Route Replanning";
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
                    <h1 style="font-size: 1.85rem;">Dynamic Route Replanning Engine</h1>
                    <p style="color: var(--text-muted);">Real-time graph recalculation upon station disruption or grid congestion</p>
                </div>
            </div>

            <!-- Disruption Warning Banner -->
            <div class="card" style="border-left: 6px solid #ef4444; background: #fff5f5; margin-bottom: 2rem;">
                <div style="display: flex; align-items: center; gap: 1.25rem;">
                    <div style="font-size: 2.5rem;">⚠️</div>
                    <div style="flex: 1;">
                        <h3 style="color: #991b1b; font-size: 1.3rem; margin-bottom: 0.25rem;">
                            Station B (EcoPulse Hub) is currently unavailable
                        </h3>
                        <p style="color: #7f1d1d; margin: 0; font-size: 0.95rem;">
                            Unexpected transformer outage reported at 16:45. Neo4j graph algorithm has automatically recalculated your route.
                        </p>
                    </div>
                    <span class="badge badge-busy">Grid Alert</span>
                </div>
            </div>

            <!-- Route Transformation Diagram -->
            <div class="card" style="margin-bottom: 2rem;">
                <h3 style="font-size: 1.2rem; margin-bottom: 1.5rem;">Graph Rerouting Flow</h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;" class="reroute-grid">
                    <!-- Original Route -->
                    <div style="background: rgba(239,68,68,0.05); border: 2px dashed #ef4444; border-radius: var(--radius-lg); padding: 1.5rem;">
                        <span class="badge badge-busy" style="margin-bottom: 1rem;">Original Disrupted Route</span>
                        <div style="font-size: 1.1rem; font-weight: 700; color: var(--navy-dark); margin-bottom: 0.5rem;">
                            Location A → <span style="text-decoration: line-through; color: #ef4444;">Station B</span> → Destination
                        </div>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">Station B experienced 100% grid downtime</p>
                    </div>

                    <!-- Alternative Recommended Route -->
                    <div style="background: rgba(0,209,118,0.08); border: 2px solid var(--primary); border-radius: var(--radius-lg); padding: 1.5rem; position: relative;">
                        <span class="route-badge">Alternative Route Found ⭐</span>
                        <div style="font-size: 1.1rem; font-weight: 700; color: var(--navy-dark); margin-bottom: 0.5rem; margin-top: 0.5rem;">
                            Location A → <strong style="color: var(--primary-hover);">Station C</strong> → Destination
                        </div>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">Station C (AeroCity Superhub) has 6 available 240kW ports</p>
                    </div>
                </div>
            </div>

            <!-- Comparison Table -->
            <div class="card">
                <h3 style="font-size: 1.25rem; margin-bottom: 1.25rem;">Route Impact Comparison</h3>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Metric</th>
                                <th>Original Route</th>
                                <th>Alternative Route (Recommended)</th>
                                <th>Variance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Distance</strong></td>
                                <td>145 km</td>
                                <td style="font-weight: 700; color: var(--navy-dark);">149 km</td>
                                <td style="color: var(--text-muted);">+4 km</td>
                            </tr>
                            <tr>
                                <td><strong>Travel Time</strong></td>
                                <td>2h 50m</td>
                                <td style="font-weight: 700; color: var(--navy-dark);">2h 56m</td>
                                <td style="color: var(--text-muted);">+6 mins</td>
                            </tr>
                            <tr>
                                <td><strong>Charging Cost</strong></td>
                                <td>₹160</td>
                                <td style="font-weight: 700; color: var(--primary-hover);">₹150</td>
                                <td style="color: var(--primary-hover); font-weight: 600;">-₹10 Saved</td>
                            </tr>
                            <tr>
                                <td><strong>Battery Safety Margin</strong></td>
                                <td>84%</td>
                                <td style="font-weight: 700; color: var(--primary-hover);">93%</td>
                                <td style="color: var(--primary-hover); font-weight: 600;">+9% Safer Reserve</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem;">
                    <a href="/route_planner.php" class="btn btn-primary">⚡ Confirm & Navigate Alternative Route</a>
                </div>
            </div>
        </main>

        <?php require_once __DIR__ . '/includes/footer.php'; ?>
    </div>
</div>
