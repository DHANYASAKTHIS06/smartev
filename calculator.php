<?php
$pageTitle = "Cost & Energy Calculator";
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
                    <h1 style="font-size: 1.85rem;">EV Cost & Energy Calculator</h1>
                    <p style="color: var(--text-muted);">Compute energy consumption, tariff costs, and charging duration</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;" class="calc-grid">
                <!-- Inputs Form -->
                <div class="card">
                    <h3 style="font-size: 1.2rem; margin-bottom: 1.25rem;">Calculator Inputs</h3>

                    <form id="calcForm">
                        <div class="form-group">
                            <label class="form-label">Trip Distance (km)</label>
                            <input type="number" id="calcDist" class="form-control" value="148" min="1" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">EV Consumption Efficiency (kWh / km)</label>
                            <input type="number" step="0.01" id="calcEff" class="form-control" value="0.16" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Current Battery State of Charge (%)</label>
                            <input type="number" id="calcSoc" class="form-control" value="68" min="0" max="100" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Electricity Tariff Rate (₹ / kWh)</label>
                            <input type="number" step="0.5" id="calcRate" class="form-control" value="18.5" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Charging Speed Intake (kW)</label>
                            <input type="number" id="calcSpeed" class="form-control" value="150" required>
                        </div>
                    </form>
                </div>

                <!-- Calculated Output Cards -->
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div class="card card-dark">
                        <span style="font-size: 0.8rem; color: var(--primary); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Estimated Total Cost</span>
                        <div style="font-size: 2.8rem; font-weight: 800; font-family: var(--font-heading); color: #ffffff; margin: 0.25rem 0;" id="resCost">
                            ₹437.72
                        </div>
                        <span style="font-size: 0.85rem; color: var(--text-light);">Compared to petrol: Saved ~₹1,120</span>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="card">
                            <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Energy Required</span>
                            <strong style="font-size: 1.4rem; color: var(--navy-dark);" id="resEnergy">23.68 kWh</strong>
                        </div>

                        <div class="card">
                            <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Cost per Kilometer</span>
                            <strong style="font-size: 1.4rem; color: var(--primary-hover);" id="resPerKm">₹2.95 / km</strong>
                        </div>

                        <div class="card">
                            <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Charging Time Needed</span>
                            <strong style="font-size: 1.4rem; color: var(--navy-dark);" id="resTime">10 mins</strong>
                        </div>

                        <div class="card">
                            <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Charging Units Needed</span>
                            <strong style="font-size: 1.4rem; color: var(--navy-dark);" id="resUnits">23.68 Units</strong>
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
    const inputs = ['calcDist', 'calcEff', 'calcSoc', 'calcRate', 'calcSpeed'];
    inputs.forEach(id => {
        document.getElementById(id).addEventListener('input', updateCalc);
    });

    function updateCalc() {
        const dist = parseFloat(document.getElementById('calcDist').value) || 0;
        const eff = parseFloat(document.getElementById('calcEff').value) || 0;
        const rate = parseFloat(document.getElementById('calcRate').value) || 0;
        const speed = parseFloat(document.getElementById('calcSpeed').value) || 1;

        const energy = dist * eff;
        const cost = energy * rate;
        const perKm = dist > 0 ? cost / dist : 0;
        const timeMins = Math.round((energy / speed) * 60);

        document.getElementById('resEnergy').innerText = energy.toFixed(2) + ' kWh';
        document.getElementById('resCost').innerText = '₹' + cost.toFixed(2);
        document.getElementById('resPerKm').innerText = '₹' + perKm.toFixed(2) + ' / km';
        document.getElementById('resTime').innerText = timeMins + ' mins';
        document.getElementById('resUnits').innerText = energy.toFixed(2) + ' Units';
    }
});
</script>
