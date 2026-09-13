<?php
$pageTitle = "Register Account";
require_once __DIR__ . '/includes/header.php';

// Handle mock registration submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    set_flash_message('success', 'Account created successfully! Welcome to EV-SmartRoute.');
    header('Location: /dashboard.php');
    exit;
}
?>

<div style="min-height: 100vh; display: grid; grid-template-columns: 1fr 1.2fr; background: #ffffff;" class="split-layout">
    <!-- Left Column -->
    <div style="background: linear-gradient(135deg, var(--navy-dark) 0%, var(--navy-card) 100%); color: #ffffff; padding: 4rem; display: flex; flex-direction: column; justify-content: space-between;">
        <a href="/index.php" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none;">
            <div style="width: 42px; height: 42px; background: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: var(--navy-dark); font-weight: bold;">⚡</div>
            <span style="font-family: var(--font-heading); font-weight: 800; font-size: 1.4rem; color: #ffffff;">EV-SmartRoute</span>
        </a>

        <div style="margin: auto 0;">
            <div class="badge badge-primary" style="margin-bottom: 1.25rem;">Smart Registration</div>
            <h1 style="font-size: 2.5rem; color: #ffffff; margin-bottom: 1.25rem;">
                Join the Intelligent EV Network Today.
            </h1>
            <p style="font-size: 1.05rem; color: var(--text-light); line-height: 1.6;">
                Save your EV battery parameters, access shortest-path graph routes, and receive personalized charging station queue predictions.
            </p>
        </div>

        <div style="font-size: 0.85rem; color: var(--text-muted);">
            Neo4j Powered Route Optimizer &copy; <?= date('Y') ?>
        </div>
    </div>

    <!-- Right Column: Registration Form -->
    <div style="display: flex; align-items: center; justify-content: center; padding: 3rem 4rem; overflow-y: auto;">
        <div style="width: 100%; max-width: 520px;">
            <div style="margin-bottom: 2rem;">
                <h2 style="font-size: 2rem; color: var(--navy-dark); margin-bottom: 0.5rem;">Create Your Account</h2>
                <p style="color: var(--text-muted);">Set up your driver and EV battery specifications</p>
            </div>

            <form action="/register.php" method="POST">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Alex Rivera" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="alex@domain.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="tel" name="phone" class="form-control" placeholder="+1 (555) 019-2834" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                </div>

                <div style="border-top: 1px solid var(--border-color); margin: 1.5rem 0; padding-top: 1.5rem;">
                    <h3 style="font-size: 1.05rem; margin-bottom: 1rem; color: var(--navy-dark);">⚡ EV Specifications</h3>
                    
                    <div class="form-group">
                        <label class="form-label">EV Model</label>
                        <input type="text" name="ev_model" class="form-control" placeholder="e.g. Tesla Model 3 Long Range" required>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label class="form-label">Battery Capacity (kWh)</label>
                            <input type="number" step="0.1" name="battery_capacity" class="form-control" placeholder="75" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Connector Type</label>
                            <select name="connector_type" class="form-select" required>
                                <option value="CCS2">CCS2 (Recommended)</option>
                                <option value="Type 2">Type 2</option>
                                <option value="CHAdeMO">CHAdeMO</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; margin-bottom: 1.25rem;">
                    Create Account
                </button>

                <div style="text-align: center; font-size: 0.95rem; color: var(--text-muted);">
                    Already registered? <a href="/login.php" style="font-weight: 700; color: var(--navy-dark);">Log in here</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
