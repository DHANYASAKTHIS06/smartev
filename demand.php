<?php
$pageTitle = "Predictive Charging Demand Analytics";
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
                    <h1 style="font-size: 1.85rem;">Predictive Charging Demand</h1>
                    <p style="color: var(--text-muted);">AI time-series forecast modeling for charging hub occupancy and queue delays</p>
                </div>
            </div>

            <!-- Smart Recommendation Banner -->
            <div class="card" style="border-left: 5px solid var(--primary); margin-bottom: 2rem; background: linear-gradient(90deg, rgba(0,209,118,0.06) 0%, #ffffff 100%);">
                <div style="display: flex; align-items: center; gap: 1.25rem;">
                    <div style="font-size: 2.2rem;">💡</div>
                    <div>
                        <h3 style="font-size: 1.2rem; color: var(--navy-dark); margin-bottom: 0.25rem;">Smart Recommendation</h3>
                        <p style="color: var(--text-muted); margin: 0; font-size: 0.95rem;">
                            “Demand is expected to increase significantly between <strong>6 PM and 7 PM</strong>. Consider charging before <strong>5:30 PM</strong> to eliminate wait times.”
                        </p>
                    </div>
                </div>
            </div>

            <!-- Main Demand Analytics Card -->
            <div class="card" style="margin-bottom: 2rem;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h2 style="font-size: 1.35rem;">Station A - AeroCity Superhub Forecast</h2>
                        <span style="font-size: 0.85rem; color: var(--text-muted);">Current Demand: <strong style="color: var(--primary-hover);">42%</strong></span>
                    </div>

                    <div style="display: flex; gap: 1rem; align-items: center;">
                        <span class="badge badge-available">🟢 Low (0-50%)</span>
                        <span class="badge badge-limited">🟡 Medium (51-75%)</span>
                        <span class="badge badge-busy">🔴 High (76-100%)</span>
                    </div>
                </div>

                <div style="background: var(--bg-main); padding: 1.5rem; border-radius: var(--radius-lg); border: 1px solid var(--border-color); margin-bottom: 2rem;">
                    <canvas id="predictiveCanvas" style="width: 100%; height: 280px;"></canvas>
                </div>

                <!-- Hourly Forecast Breakdown Grid -->
                <h3 style="font-size: 1.1rem; margin-bottom: 1rem;">Hourly Demand & Queue Forecast</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 1rem;">
                    <div class="stat-card" style="text-align: center;">
                        <span style="font-size: 0.8rem; color: var(--text-muted); display: block;">5:00 PM</span>
                        <strong style="font-size: 1.4rem; color: #f59e0b; font-family: var(--font-heading);">65%</strong>
                        <span class="badge badge-limited" style="margin-top: 0.4rem; font-size: 0.7rem;">🟡 Medium</span>
                    </div>

                    <div class="stat-card" style="text-align: center; border-color: #ef4444;">
                        <span style="font-size: 0.8rem; color: var(--text-muted); display: block;">6:00 PM</span>
                        <strong style="font-size: 1.4rem; color: #ef4444; font-family: var(--font-heading);">84%</strong>
                        <span class="badge badge-busy" style="margin-top: 0.4rem; font-size: 0.7rem;">🔴 Peak</span>
                    </div>

                    <div class="stat-card" style="text-align: center; border-color: #ef4444; background: rgba(239,68,68,0.03);">
                        <span style="font-size: 0.8rem; color: var(--text-muted); display: block;">7:00 PM</span>
                        <strong style="font-size: 1.4rem; color: #ef4444; font-family: var(--font-heading);">91%</strong>
                        <span class="badge badge-busy" style="margin-top: 0.4rem; font-size: 0.7rem;">🔴 Max Queue</span>
                    </div>

                    <div class="stat-card" style="text-align: center;">
                        <span style="font-size: 0.8rem; color: var(--text-muted); display: block;">8:00 PM</span>
                        <strong style="font-size: 1.4rem; color: #f59e0b; font-family: var(--font-heading);">72%</strong>
                        <span class="badge badge-limited" style="margin-top: 0.4rem; font-size: 0.7rem;">🟡 Medium</span>
                    </div>

                    <div class="stat-card" style="text-align: center;">
                        <span style="font-size: 0.8rem; color: var(--text-muted); display: block;">9:00 PM</span>
                        <strong style="font-size: 1.4rem; color: var(--primary-hover); font-family: var(--font-heading);">48%</strong>
                        <span class="badge badge-available" style="margin-top: 0.4rem; font-size: 0.7rem;">🟢 Low</span>
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
    renderDemandChart('predictiveCanvas', forecast);
});
</script>
