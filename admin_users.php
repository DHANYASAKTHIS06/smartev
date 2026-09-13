<?php
$pageTitle = "User Management - Admin";
require_once __DIR__ . '/includes/header.php';

$users = [
    ['id' => 'USR-8829', 'name' => 'Alex Rivera', 'email' => 'alex.rivera@evmobility.io', 'ev' => 'Tesla Model 3', 'trips' => 28, 'status' => 'Active'],
    ['id' => 'USR-7740', 'name' => 'Sarah Connor', 'email' => 'sarah.c@cyber.org', 'ev' => 'Hyundai Ioniq 5', 'trips' => 14, 'status' => 'Active'],
    ['id' => 'USR-6120', 'name' => 'Vikram Sharma', 'email' => 'vikram@tech.in', 'ev' => 'Tata Nexon EV', 'trips' => 42, 'status' => 'Active'],
    ['id' => 'USR-5012', 'name' => 'Michael Chang', 'email' => 'mchang@global.com', 'ev' => 'Porsche Taycan', 'trips' => 9, 'status' => 'Blocked']
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
                    <h1 style="font-size: 1.85rem;">User Management</h1>
                    <p style="color: var(--text-muted);">Manage registered EV drivers, roles, and account access</p>
                </div>
                <button class="btn btn-primary btn-sm" onclick="showToast('Add User dialog opened', 'info')">➕ Add New User</button>
            </div>

            <div class="card">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 1rem;">
                    <input type="text" placeholder="Search user by name or email..." class="form-control" style="max-width: 320px;">
                    <span class="badge badge-primary">Total: 4 Registered Accounts</span>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Registered EV</th>
                                <th>Trips Logged</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $u): ?>
                                <tr>
                                    <td><strong><?= $u['id'] ?></strong></td>
                                    <td><?= htmlspecialchars($u['name']) ?></td>
                                    <td><?= htmlspecialchars($u['email']) ?></td>
                                    <td><?= $u['ev'] ?></td>
                                    <td><?= $u['trips'] ?></td>
                                    <td>
                                        <span class="badge <?= $u['status'] === 'Active' ? 'badge-available' : 'badge-busy' ?>">
                                            <?= $u['status'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 0.35rem;">
                                            <button class="btn btn-outline btn-sm" onclick="showToast('Edit user details', 'info')">✏️ Edit</button>
                                            <?php if ($u['status'] === 'Active'): ?>
                                                <button class="btn btn-outline btn-sm" style="color: #ef4444;" onclick="showToast('User blocked!', 'danger')">🚫 Block</button>
                                            <?php else: ?>
                                                <button class="btn btn-outline btn-sm" style="color: var(--primary);" onclick="showToast('User unblocked', 'success')">✅ Unblock</button>
                                            <?php endif; ?>
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
