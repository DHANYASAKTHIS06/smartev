<?php
$pageTitle = "EV Management - Admin";
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
                    <h1 style="font-size: 1.85rem;">EV Model Profiles & Specifications</h1>
                    <p style="color: var(--text-muted);">Manage EV models, battery capacities, and charging connector specs</p>
                </div>
                <button class="btn btn-primary btn-sm" onclick="openModal('addEvModal')">➕ Register New EV Model</button>
            </div>

            <div class="card">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>EV ID</th>
                                <th>Model & Brand</th>
                                <th>Battery Capacity</th>
                                <th>Max Charging Power</th>
                                <th>Connector Type</th>
                                <th>Efficiency Rate</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sampleData['user_evs'] as $ev): ?>
                                <tr>
                                    <td><strong><?= $ev['id'] ?></strong></td>
                                    <td><strong><?= htmlspecialchars($ev['model']) ?></strong></td>
                                    <td><?= $ev['battery_capacity'] ?> kWh</td>
                                    <td><?= $ev['max_charging_power'] ?> kW DC</td>
                                    <td><span class="badge badge-primary"><?= $ev['connector_type'] ?></span></td>
                                    <td><?= $ev['efficiency'] ?> kWh/km</td>
                                    <td>
                                        <div style="display: flex; gap: 0.35rem;">
                                            <button class="btn btn-outline btn-sm" onclick="showToast('Editing EV Model specs', 'info')">✏️ Edit</button>
                                            <button class="btn btn-outline btn-sm" style="color: #ef4444;" onclick="showToast('EV Model deleted', 'danger')">🗑️ Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <?php require_once __DIR__ . '/includes/modals.php'; ?>
        <?php require_once __DIR__ . '/includes/footer.php'; ?>
    </div>
</div>
