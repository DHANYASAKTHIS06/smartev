<?php
$pageTitle = "User Login";
require_once __DIR__ . '/includes/header.php';

// Handle mock login submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    set_flash_message('success', 'Welcome back! Logged in successfully.');
    header('Location: /dashboard.php');
    exit;
}
?>

<div style="min-height: 100vh; display: grid; grid-template-columns: 1fr 1fr; background: #ffffff;" class="split-layout">
    <!-- Left Column: Graphic & Description -->
    <div style="background: linear-gradient(135deg, var(--navy-dark) 0%, var(--navy-card) 100%); color: #ffffff; padding: 4rem; display: flex; flex-direction: column; justify-content: space-between; position: relative;">
        <div>
            <a href="/index.php" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none;">
                <div style="width: 42px; height: 42px; background: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: var(--navy-dark); font-weight: bold;">⚡</div>
                <span style="font-family: var(--font-heading); font-weight: 800; font-size: 1.4rem; color: #ffffff;">EV-SmartRoute</span>
            </a>
        </div>

        <div style="margin: auto 0;">
            <div style="font-size: 4rem; margin-bottom: 1.5rem;">🔋🚗</div>
            <h1 style="font-size: 2.8rem; color: #ffffff; margin-bottom: 1.25rem;">
                Powering Next-Gen Electric Mobility.
            </h1>
            <p style="font-size: 1.1rem; color: var(--text-light); line-height: 1.7; max-width: 480px;">
                Experience graph-based journey optimization with real-time battery analytics and AI predictive station management.
            </p>
        </div>

        <div style="font-size: 0.85rem; color: var(--text-muted);">
            &copy; <?= date('Y') ?> Neo4j EV Mobility Platform. All rights reserved.
        </div>
    </div>

    <!-- Right Column: Login Form -->
    <div style="display: flex; align-items: center; justify-content: center; padding: 4rem;">
        <div style="width: 100%; max-width: 440px;">
            <div style="margin-bottom: 2.5rem;">
                <h2 style="font-size: 2rem; color: var(--navy-dark); margin-bottom: 0.5rem;">Welcome back, EV traveler. 👋</h2>
                <p style="color: var(--text-muted);">Sign in to access your intelligent EV journey dashboard</p>
            </div>

            <form action="/login.php" method="POST">
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="alex.rivera@evmobility.io" value="alex.rivera@evmobility.io" required>
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                        <label class="form-label" style="margin-bottom: 0;">Password</label>
                        <a href="#" style="font-size: 0.85rem; color: var(--primary-hover); font-weight: 500;">Forgot Password?</a>
                    </div>
                    <input type="password" name="password" class="form-control" value="password123" required>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer; color: var(--text-muted);">
                        <input type="checkbox" checked style="accent-color: var(--primary);"> Remember me on this device
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; margin-bottom: 1.5rem;">
                    Sign In to Account
                </button>

                <div style="text-align: center; font-size: 0.95rem; color: var(--text-muted);">
                    Don't have an EV account? <a href="/register.php" style="font-weight: 700; color: var(--navy-dark);">Register now</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
@media (max-width: 900px) {
    .split-layout { grid-template-columns: 1fr; }
    .split-layout > div:first-child { display: none; }
}
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
