<?php
$pageTitle = "EV Management Profiles";
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
                    <h1 style="font-size: 1.85rem;">EV Garage & Profiles</h1>
                    <p style="color: var(--text-muted);">Manage your registered electric vehicles and battery parameters</p>
                </div>

                <button class="btn btn-primary" onclick="openModal('addEvModal')">
                    ⚡ Add New Vehicle Profile
                </button>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem;">
                <?php foreach ($sampleData['user_evs'] as $ev): ?>
                    <div class="card" style="<?= $ev['is_default'] ? 'border-color: var(--primary); box-shadow: var(--shadow-glow);' : '' ?>">
                        <?php if ($ev['is_default']): ?>
                            <span class="route-badge">Default Vehicle</span>
                        <?php endif; ?>

                        <div style="height: 180px; margin: -1.5rem -1.5rem 1.25rem -1.5rem; overflow: hidden; position: relative;">
                            <img src="<?= $ev['image'] ?>" alt="<?= htmlspecialchars($ev['model']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 1rem; background: linear-gradient(0deg, rgba(15,23,42,0.9) 0%, transparent 100%); color: #ffffff;">
                                <h3 style="color: #ffffff; font-size: 1.2rem; margin: 0;"><?= htmlspecialchars($ev['model']) ?></h3>
                                <span style="font-size: 0.8rem; color: var(--primary); font-weight: 600;"><?= htmlspecialchars($ev['brand']) ?></span>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.85rem; font-size: 0.9rem; margin-bottom: 1.25rem;">
                            <div style="background: var(--bg-main); padding: 0.6rem 0.8rem; border-radius: var(--radius-sm);">
                                <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Battery Capacity</span>
                                <strong><?= $ev['battery_capacity'] ?> kWh</strong>
                            </div>
                            <div style="background: var(--bg-main); padding: 0.6rem 0.8rem; border-radius: var(--radius-sm);">
                                <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Current Charge</span>
                                <strong style="color: var(--primary-hover);"><?= $ev['current_battery'] ?>% SOC</strong>
                            </div>
                            <div style="background: var(--bg-main); padding: 0.6rem 0.8rem; border-radius: var(--radius-sm);">
                                <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Max Power</span>
                                <strong><?= $ev['max_charging_power'] ?> kW DC</strong>
                            </div>
                            <div style="background: var(--bg-main); padding: 0.6rem 0.8rem; border-radius: var(--radius-sm);">
                                <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Connector</span>
                                <strong><?= $ev['connector_type'] ?></strong>
                            </div>
                            <div style="grid-column: span 2; background: var(--bg-main); padding: 0.6rem 0.8rem; border-radius: var(--radius-sm);">
                                <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Energy Efficiency</span>
                                <strong><?= $ev['efficiency'] ?> kWh / km</strong>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 0.5rem; border-top: 1px solid var(--border-color); padding-top: 1rem;">
                            <button class="btn btn-outline btn-sm" onclick="showToast('EV configuration updated!', 'info')">✏️ Edit</button>
                            <?php if (!$ev['is_default']): ?>
                                <button class="btn btn-secondary btn-sm" onclick="showToast('Set as active vehicle!', 'success')">Set Default</button>
                                <button class="btn btn-outline btn-sm" style="color: #ef4444;" onclick="showToast('EV profile removed', 'danger')">🗑️ Delete</button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>

        <?php require_once __DIR__ . '/includes/modals.php'; ?>
        <?php require_once __DIR__ . '/includes/footer.php'; ?>
    </div>
</div>
