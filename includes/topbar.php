<!-- Authenticated Header Topbar -->
<header class="topbar" style="position: fixed; top: 0; right: 0; left: var(--sidebar-width); height: var(--topbar-height); background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border-color); z-index: 1000; display: flex; align-items: center; justify-content: space-between; padding: 0 2rem; transition: var(--transition);">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <button id="mobileMenuBtn" style="display: none; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-main);">☰</button>
        
        <div style="position: relative; width: 320px;" class="desktop-only">
            <input type="text" placeholder="Search charging hubs, routes, stations..." class="form-control" style="padding-left: 2.5rem; border-radius: 9999px; height: 40px; font-size: 0.875rem; background: var(--bg-main);">
            <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.9rem;">🔍</span>
        </div>
    </div>

    <div style="display: flex; align-items: center; gap: 1.25rem;">
        <!-- Live EV Battery Indicator Badge -->
        <div class="badge badge-primary" style="padding: 0.4rem 0.85rem; display: flex; align-items: center; gap: 0.5rem; border-radius: 9999px; font-weight: 600;">
            <span style="color: var(--primary-hover);">🔋</span>
            <span>Tesla Model 3: <strong>68%</strong> (~214 km)</span>
        </div>

        <!-- Notification Bell Widget -->
        <a href="/notifications.php" style="position: relative; background: var(--bg-main); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-color); color: var(--text-main); text-decoration: none;">
            <span style="font-size: 1.1rem;">🔔</span>
            <span style="position: absolute; top: 2px; right: 2px; width: 10px; height: 10px; background: #ef4444; border-radius: 50%; border: 2px solid #ffffff;"></span>
        </a>

        <!-- User Profile Pill -->
        <div style="display: flex; align-items: center; gap: 0.75rem; border-left: 1px solid var(--border-color); padding-left: 1.25rem;">
            <img src="<?= $_SESSION['user']['avatar'] ?>" alt="User Avatar" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary);">
            <div>
                <span style="display: block; font-weight: 700; font-size: 0.9rem; color: var(--text-main); line-height: 1.2;"><?= htmlspecialchars($_SESSION['user']['name']) ?></span>
                <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: capitalize;"><?= htmlspecialchars($_SESSION['user']['role']) ?></span>
            </div>
        </div>
    </div>
</header>
