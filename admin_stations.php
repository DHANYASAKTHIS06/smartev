<?php
$pageTitle = "Station Management - Admin";
$sampleData = require_once __DIR__ . '/data/sample_data.php';
require_once __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require_once __DIR__ . '/includes/admin_sidebar.php'; ?>

    <div class="main-content">
        <?php require_once __DIR__ . '/includes/topbar.php'; ?>
        <?php require_once __DIR__ . '/includes/alerts.php'; ?>

        <main class="content-container">
            <div class="dashboard-header">
                <div>
                    <h1 style="font-size: 1.85rem;">Charging Station Hub Management</h1>
                    <p style="color: var(--text-muted);">Add, edit, and update station locations, tariffs, and status</p>
                </div>
                <button class="btn btn-primary btn-sm" onclick="showToast('Add Station Modal', 'info')">➕ Add Charging Hub</button>
            </div>

            <div class="card">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Station ID</th>
                                <th>Station Name</th>
                                <th>Location</th>
                                <th>Speed (kW)</th>
                                <th>Chargers (Avail / Total)</th>
                                <th>Tariff Rate</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sampleData['charging_stations'] as $stn): ?>
                                <tr>
                                    <td><strong><?= $stn['id'] ?></strong></td>
                                    <td><strong><?= htmlspecialchars($stn['name']) ?></strong></td>
                                    <td><?= htmlspecialchars($stn['location']) ?></td>
                                    <td><?= $stn['charging_speed_kw'] ?> kW</td>
                                    <td><?= $stn['available_chargers'] ?> / <?= $stn['total_chargers'] ?></td>
                                    <td>₹<?= $stn['price_per_kwh'] ?> / kWh</td>
                                    <td>
                                        <span class="badge badge-<?= $stn['status_code'] ?>"><?= $stn['status'] ?></span>
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 0.35rem;">
                                            <button class="btn btn-outline btn-sm" onclick="showToast('Edit Station Details', 'info')">✏️ Edit</button>
                                            <button class="btn btn-outline btn-sm" style="color: #ef4444;" onclick="showToast('Station disabled!', 'danger')">Disable</button>
                                        </div>
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
