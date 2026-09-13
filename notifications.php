<?php
$pageTitle = "Notifications Center";
require_once __DIR__ . '/includes/header.php';

$notifications = [
    [
        'id' => 1,
        'icon' => '🔋',
        'title' => 'Battery state alert below 20%',
        'message' => 'Your active EV battery is currently at 18%. Automatic station recommendation suggested.',
        'time' => '10 mins ago',
        'type' => 'Important',
        'badge' => 'badge-busy',
        'is_unread' => true
    ],
    [
        'id' => 2,
        'icon' => '🔌',
        'title' => 'Charging station available nearby',
        'message' => 'AeroCity HyperCharge Superhub has 2 new 240kW CCS2 ports available.',
        'time' => '45 mins ago',
        'type' => 'Unread',
        'badge' => 'badge-available',
        'is_unread' => true
    ],
    [
        'id' => 3,
        'icon' => '⚠️',
        'title' => 'Station congestion predicted',
        'message' => 'Demand surge predicted at EcoPulse Metro Hub between 6:00 PM and 7:00 PM.',
        'time' => '2 hours ago',
        'type' => 'Important',
        'badge' => 'badge-limited',
        'is_unread' => false
    ],
    [
        'id' => 4,
        'icon' => '🔄',
        'title' => 'Route has been automatically updated',
        'message' => 'Dynamic reroute triggered due to maintenance on Highway Segment 4.',
        'time' => 'Yesterday',
        'type' => 'Read',
        'badge' => 'badge-primary',
        'is_unread' => false
    ],
    [
        'id' => 5,
        'icon' => '✅',
        'title' => 'Charging session completed',
        'message' => 'Session at AeroCity Hub completed. Added 44.2 kWh in 18 minutes (Cost: ₹155).',
        'time' => '2 days ago',
        'type' => 'Read',
        'badge' => 'badge-available',
        'is_unread' => false
    ]
];
?>

<div class="app-layout">
    <?php require_once __DIR__ . '/includes/sidebar.php'; ?>

    <div class="main-content">
        <?php require_once __DIR__ . '/includes/topbar.php'; ?>
        <?php require_once __DIR__ . '/includes/alerts.php'; ?>

        <main class="content-container">
            <div class="dashboard-header">
                <div>
                    <h1 style="font-size: 1.85rem;">Notifications Center</h1>
                    <p style="color: var(--text-muted);">Real-time alerts for battery levels, station congestion & route rerouting</p>
                </div>

                <button class="btn btn-outline btn-sm" onclick="showToast('All notifications marked as read', 'success')">
                    Mark All as Read
                </button>
            </div>

            <div class="card">
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <?php foreach ($notifications as $n): ?>
                        <div style="display: flex; align-items: flex-start; gap: 1.25rem; padding: 1.25rem; border-radius: var(--radius-md); background: <?= $n['is_unread'] ? 'rgba(0,209,118,0.04)' : 'var(--bg-main)' ?>; border: 1px solid <?= $n['is_unread'] ? 'rgba(0,209,118,0.2)' : 'var(--border-color)' ?>;">
                            <div style="font-size: 1.8rem; background: #ffffff; width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow-sm); flex-shrink: 0;">
                                <?= $n['icon'] ?>
                            </div>

                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.25rem;">
                                    <h4 style="font-size: 1.05rem; margin: 0; color: var(--navy-dark);"><?= htmlspecialchars($n['title']) ?></h4>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <span class="badge <?= $n['badge'] ?>"><?= $n['type'] ?></span>
                                        <span style="font-size: 0.8rem; color: var(--text-muted);"><?= $n['time'] ?></span>
                                    </div>
                                </div>
                                <p style="margin: 0; font-size: 0.9rem; color: var(--text-muted);"><?= htmlspecialchars($n['message']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>

        <?php require_once __DIR__ . '/includes/footer.php'; ?>
    </div>
</div>
