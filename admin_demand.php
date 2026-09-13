<?php
$pageTitle = "Demand Data Management - Admin";
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
                    <h1 style="font-size: 1.85rem;">Predictive Demand Data Management</h1>
                    <p style="color: var(--text-muted);">Manage historical telemetry datasets, training models, and forecast parameters</p>
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    <button class="btn btn-outline btn-sm" onclick="showToast('Import CSV Datasets', 'info')">📥 Import Historical Data</button>
                    <button class="btn btn-primary btn-sm" onclick="showToast('Executing AI Prediction Model...', 'success')">⚡ Run Model Training</button>
                </div>
            </div>

            <div class="card" style="margin-bottom: 2rem;">
                <h3 style="font-size: 1.2rem; margin-bottom: 1rem;">24-Hour Predictive Time Series Dataset</h3>
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Hour</th>
                                <th>Occupancy Rate %</th>
                                <th>Queue Length</th>
                                <th>Est. Wait Time</th>
                                <th>Congestion Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sampleData['demand_forecast'] as $row): ?>
                                <tr>
                                    <td><strong><?= $row['hour'] ?></strong></td>
                                    <td><?= $row['demand'] ?>%</td>
                                    <td><?= $row['queue'] ?> Cars</td>
                                    <td><?= $row['wait'] ?></td>
                                    <td>
                                        <span class="badge <?= $row['level'] === 'High' ? 'badge-busy' : ($row['level'] === 'Medium' ? 'badge-limited' : 'badge-available') ?>">
                                            <?= $row['level'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline btn-sm" onclick="showToast('Edit Demand Record', 'info')">✏️ Edit</button>
                                        <button class="btn btn-outline btn-sm" style="color: #ef4444;" onclick="showToast('Record deleted', 'danger')">Delete</button>
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
