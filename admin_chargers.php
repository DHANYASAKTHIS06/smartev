<?php
$pageTitle = "Charger Management - Admin";
require_once __DIR__ . '/includes/header.php';

$chargers = [
    ['id' => 'PORT-101', 'station' => 'AeroCity Superhub', 'type' => 'CCS2', 'speed' => '240 kW', 'price' => 18.5, 'status' => 'Available', 'badge' => 'badge-available'],
    ['id' => 'PORT-102', 'station' => 'AeroCity Superhub', 'type' => 'CCS2', 'speed' => '240 kW', 'price' => 18.5, 'status' => 'Occupied', 'badge' => 'badge-limited'],
    ['id' => 'PORT-201', 'station' => 'EcoPulse Metro Park', 'type' => 'CHAdeMO', 'speed' => '150 kW', 'price' => 16.0, 'status' => 'Maintenance', 'badge' => 'badge-busy'],
    ['id' => 'PORT-301', 'station' => 'VoltNode Highway Oasis', 'type' => 'Type 2', 'speed' => '350 kW', 'price' => 20.0, 'status' => 'Offline', 'badge' => 'badge-busy']
];
?>

<div class="app-layout">
    <?php require_once __DIR__ . '/includes/admin_sidebar.php'; ?>

    <div class="main-content">
        <?php require_once __DIR__ . '/includes/topbar.php'; ?>
        <?php require_once __DIR__ . '/includes/alerts.php'; ?>

        <main class="content-container">
            <div class="dashboard-header">
                <div>
                    <h1 style="font-size: 1.85rem;">Charger Point Unit Management</h1>
                    <p style="color: var(--text-muted);">Manage individual physical charging ports, statuses, and maintenance logs</p>
                </div>
                <button class="btn btn-primary btn-sm" onclick="showToast('Add Charger Unit', 'info')">➕ Add Charger Point</button>
            </div>

            <div class="card">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Charger ID</th>
                                <th>Assigned Station Hub</th>
                                <th>Connector Type</th>
                                <th>Speed (kW)</th>
                                <th>Tariff Price</th>
                                <th>Current Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($chargers as $c): ?>
                                <tr>
                                    <td><strong><?= $c['id'] ?></strong></td>
                                    <td><?= htmlspecialchars($c['station']) ?></td>
                                    <td><span class="badge badge-primary"><?= $c['type'] ?></span></td>
                                    <td><?= $c['speed'] ?></td>
                                    <td>₹<?= $c['price'] ?> / kWh</td>
                                    <td><span class="badge <?= $c['badge'] ?>"><?= $c['status'] ?></span></td>
                                    <td>
                                        <div style="display: flex; gap: 0.35rem;">
                                            <button class="btn btn-outline btn-sm" onclick="showToast('Update Charger Status', 'info')">Toggle Status</button>
                                            <button class="btn btn-outline btn-sm" style="color: #ef4444;" onclick="showToast('Charger removed', 'danger')">Delete</button>
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
