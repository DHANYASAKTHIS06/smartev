<?php
$pageTitle = "Favorites & Saved Items";
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
                    <h1 style="font-size: 1.85rem;">Favorites & Saved Locations</h1>
                    <p style="color: var(--text-muted);">Quick access to preferred charging hubs and frequent routes</p>
                </div>
            </div>

            <!-- Favorite Stations Section -->
            <h2 style="font-size: 1.3rem; margin-bottom: 1rem;">⭐ Favorite Charging Stations</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
                <?php foreach (array_slice($sampleData['charging_stations'], 0, 2) as $stn): ?>
                    <div class="card">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
                            <h3 style="font-size: 1.15rem; margin: 0;"><?= htmlspecialchars($stn['name']) ?></h3>
                            <span class="badge badge-available">🟢 Available</span>
                        </div>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem;">📍 <?= htmlspecialchars($stn['location']) ?> (<?= $stn['distance_km'] ?> km)</p>
                        
                        <div style="display: flex; justify-content: space-between; gap: 0.5rem; border-top: 1px solid var(--border-color); padding-top: 1rem;">
                            <a href="/station_detail.php?id=<?= $stn['id'] ?>" class="btn btn-primary btn-sm">📍 Quick Navigate</a>
                            <button class="btn btn-outline btn-sm" style="color: #ef4444;" onclick="showToast('Removed from favorites', 'danger')">Remove</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Favorite Routes Section -->
            <h2 style="font-size: 1.3rem; margin-bottom: 1rem;">🛣️ Favorite Saved Routes</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
                <div class="card">
                    <h3 style="font-size: 1.15rem; margin-bottom: 0.25rem;">Home ➔ Tech Hub East</h3>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem;">148 km • 1 Stop at AeroCity Hub</p>
                    <div style="display: flex; justify-content: space-between; gap: 0.5rem;">
                        <a href="/route_planner.php" class="btn btn-primary btn-sm">⚡ Plan Now</a>
                        <button class="btn btn-outline btn-sm" style="color: #ef4444;" onclick="showToast('Route removed', 'danger')">Remove</button>
                    </div>
                </div>
            </div>

            <!-- Saved Locations Section -->
            <h2 style="font-size: 1.3rem; margin-bottom: 1rem;">📍 Saved Locations</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.25rem;">
                <div class="card">
                    <strong style="display: block; font-size: 1.05rem;">🏡 Residence</strong>
                    <p style="font-size: 0.85rem; color: var(--text-muted);">Downtown Central Plaza</p>
                </div>
                <div class="card">
                    <strong style="display: block; font-size: 1.05rem;">🏢 Office HQ</strong>
                    <p style="font-size: 0.85rem; color: var(--text-muted);">Cyber City Sector 21</p>
                </div>
            </div>
        </main>

        <?php require_once __DIR__ . '/includes/footer.php'; ?>
    </div>
</div>
