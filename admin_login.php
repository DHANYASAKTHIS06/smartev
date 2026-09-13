<?php
$pageTitle = "Admin Console Login";
require_once __DIR__ . '/includes/header.php';

// Handle mock admin login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['user'] = [
        'id' => 'ADM-001',
        'name' => 'System Administrator',
        'email' => 'admin@evmobility.io',
        'role' => 'admin',
        'ev_model' => 'Tesla Model S Plaid',
        'battery_capacity' => 100,
        'current_battery' => 90,
        'connector_type' => 'CCS2',
        'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&q=80&w=250'
    ];
    set_flash_message('success', 'Logged into Admin Console');
    header('Location: /admin_dashboard.php');
    exit;
}
?>

<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: var(--navy-dark); padding: 2rem;">
    <div style="width: 100%; max-width: 440px; background: var(--navy-card); border-radius: var(--radius-xl); border: 1px solid var(--navy-light); padding: 2.5rem; color: #ffffff; box-shadow: var(--shadow-lg);">
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="width: 54px; height: 54px; background: #3b82f6; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1rem auto; box-shadow: 0 0 20px rgba(59,130,246,0.4);">
                ⚙️
            </div>
            <h1 style="font-size: 1.8rem; color: #ffffff; margin-bottom: 0.25rem;">Admin Portal Access</h1>
            <p style="color: var(--text-light); font-size: 0.9rem;">Neo4j Graph Network & Demand Management</p>
        </div>

        <form action="/admin_login.php" method="POST">
            <div class="form-group">
                <label class="form-label" style="color: var(--text-light);">Admin Username / Email</label>
                <input type="text" name="username" class="form-control" value="admin@evmobility.io" style="background: var(--navy-dark); border-color: var(--navy-light); color: #ffffff;" required>
            </div>

            <div class="form-group">
                <label class="form-label" style="color: var(--text-light);">Security Password</label>
                <input type="password" name="password" class="form-control" value="admin123" style="background: var(--navy-dark); border-color: var(--navy-light); color: #ffffff;" required>
            </div>

            <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; background: #3b82f6; color: #ffffff; border: none; margin-top: 1rem;">
                Authenticate & Access Console
            </button>

            <div style="text-align: center; margin-top: 1.5rem;">
                <a href="/login.php" style="color: var(--text-light); font-size: 0.85rem;">← Return to Driver Login</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
