<?php
$pageTitle = "Trip History & Logs";
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
                    <h1 style="font-size: 1.85rem;">Trip History & Logs</h1>
                    <p style="color: var(--text-muted);">Historical journey logs, charging stops, energy consumed & trip receipts</p>
                </div>
            </div>

            <!-- Analytics Summary Cards -->
            <div class="stats-grid" style="margin-bottom: 2rem;">
                <div class="stat-card">
                    <span class="stat-title">Completed Trips</span>
                    <div class="stat-value">28</div>
                </div>
                <div class="stat-card">
                    <span class="stat-title">Total Distance</span>
                    <div class="stat-value">3,420 km</div>
                </div>
                <div class="stat-card">
                    <span class="stat-title">Energy Used</span>
                    <div class="stat-value">547 kWh</div>
                </div>
                <div class="stat-card">
                    <span class="stat-title">Total Cost</span>
                    <div class="stat-value">₹3,840</div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 1rem;">
                    <input type="text" placeholder="Search by start or destination..." class="form-control" style="max-width: 320px;">
                    
                    <div style="display: flex; gap: 0.5rem;">
                        <button class="btn btn-outline btn-sm">Filter Status</button>
                        <button class="btn btn-outline btn-sm">Export CSV</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Start Location</th>
                                <th>Destination</th>
                                <th>Distance</th>
                                <th>Charging Stops</th>
                                <th>Energy Used</th>
                                <th>Total Cost</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sampleData['trip_history'] as $trip): ?>
                                <tr>
                                    <td><strong><?= $trip['date'] ?></strong></td>
                                    <td><?= htmlspecialchars($trip['start']) ?></td>
                                    <td><?= htmlspecialchars($trip['destination']) ?></td>
                                    <td><?= $trip['distance_km'] ?> km</td>
                                    <td><span class="badge badge-primary"><?= $trip['charging_stops'] ?> Stop</span></td>
                                    <td><?= $trip['energy_used_kwh'] ?> kWh</td>
                                    <td><strong>₹<?= $trip['cost_inr'] ?></strong></td>
                                    <td><span class="badge badge-available">🟢 <?= $trip['status'] ?></span></td>
                                    <td>
                                        <button class="btn btn-outline btn-sm" onclick="showToast('Loading trip details receipt...', 'info')">Details</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <?php require_once __DIR__ . '/includes/footer.php'; ?>
    </div>
</div>
