<!-- User Navigation Sidebar -->
<aside class="sidebar" id="appSidebar" style="position: fixed; top: 0; left: 0; bottom: 0; width: var(--sidebar-width); background: var(--navy-dark); color: var(--text-white); z-index: 1100; transition: var(--transition); display: flex; flex-direction: column; border-right: 1px solid var(--navy-light);">
    <div style="padding: 1.5rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
        <a href="/dashboard.php" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none;">
            <div style="width: 38px; height: 38px; background: var(--primary); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; color: var(--navy-dark); font-weight: bold;">⚡</div>
            <div class="sidebar-brand-text">
                <span style="font-family: var(--font-heading); font-weight: 800; font-size: 1.15rem; color: #ffffff;">EV-SmartRoute</span>
                <span style="display: block; font-size: 0.65rem; color: var(--primary); font-weight: 700; text-transform: uppercase;">Neo4j Mobility</span>
            </div>
        </a>
        <button id="sidebarToggle" style="background: none; border: none; color: var(--text-light); cursor: pointer; font-size: 1.2rem;">◀</button>
    </div>

    <div style="padding: 1rem 0; flex: 1; overflow-y: auto;">
        <div style="padding: 0 1.25rem 0.5rem 1.25rem; font-size: 0.7rem; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.8px;">Main Menu</div>

        <ul style="list-style: none; margin: 0; padding: 0;">
            <li>
                <a href="/dashboard.php" class="sidebar-link <?= is_active_page('dashboard.php') ?>" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.75rem 1.5rem; color: var(--text-light); font-weight: 500; font-size: 0.925rem; border-left: 3px solid transparent; transition: var(--transition);">
                    <span>📊</span> <span class="nav-label">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="/route_planner.php" class="sidebar-link <?= is_active_page('route_planner.php') ?>" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.75rem 1.5rem; color: var(--text-light); font-weight: 500; font-size: 0.925rem; border-left: 3px solid transparent;">
                    <span>🗺️</span> <span class="nav-label">Plan Journey</span>
                </a>
            </li>
            <li>
                <a href="/battery_routing.php" class="sidebar-link <?= is_active_page('battery_routing.php') ?>" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.75rem 1.5rem; color: var(--text-light); font-weight: 500; font-size: 0.925rem; border-left: 3px solid transparent;">
                    <span>🔋</span> <span class="nav-label">Battery Routing</span>
                </a>
            </li>
            <li>
                <a href="/stations.php" class="sidebar-link <?= is_active_page('stations.php') ?>" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.75rem 1.5rem; color: var(--text-light); font-weight: 500; font-size: 0.925rem; border-left: 3px solid transparent;">
                    <span>🔌</span> <span class="nav-label">Charging Stations</span>
                </a>
            </li>
            <li>
                <a href="/demand.php" class="sidebar-link <?= is_active_page('demand.php') ?>" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.75rem 1.5rem; color: var(--text-light); font-weight: 500; font-size: 0.925rem; border-left: 3px solid transparent;">
                    <span>📈</span> <span class="nav-label">Demand Prediction</span>
                </a>
            </li>
            <li>
                <a href="/dynamic_reroute.php" class="sidebar-link <?= is_active_page('dynamic_reroute.php') ?>" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.75rem 1.5rem; color: var(--text-light); font-weight: 500; font-size: 0.925rem; border-left: 3px solid transparent;">
                    <span>🔄</span> <span class="nav-label">Dynamic Reroute</span>
                </a>
            </li>
            <li>
                <a href="/graph.php" class="sidebar-link <?= is_active_page('graph.php') ?>" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.75rem 1.5rem; color: var(--text-light); font-weight: 500; font-size: 0.925rem; border-left: 3px solid transparent;">
                    <span>🌐</span> <span class="nav-label">Neo4j Graph</span>
                </a>
            </li>
            
            <div style="padding: 1.25rem 1.25rem 0.5rem 1.25rem; font-size: 0.7rem; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.8px;">User Suite</div>

            <li>
                <a href="/ev_profile.php" class="sidebar-link <?= is_active_page('ev_profile.php') ?>" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.75rem 1.5rem; color: var(--text-light); font-weight: 500; font-size: 0.925rem; border-left: 3px solid transparent;">
                    <span>🚗</span> <span class="nav-label">EV Profiles</span>
                </a>
            </li>
            <li>
                <a href="/trip_history.php" class="sidebar-link <?= is_active_page('trip_history.php') ?>" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.75rem 1.5rem; color: var(--text-light); font-weight: 500; font-size: 0.925rem; border-left: 3px solid transparent;">
                    <span>🕒</span> <span class="nav-label">Trip History</span>
                </a>
            </li>
            <li>
                <a href="/favorites.php" class="sidebar-link <?= is_active_page('favorites.php') ?>" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.75rem 1.5rem; color: var(--text-light); font-weight: 500; font-size: 0.925rem; border-left: 3px solid transparent;">
                    <span>⭐</span> <span class="nav-label">Favorites</span>
                </a>
            </li>
            <li>
                <a href="/notifications.php" class="sidebar-link <?= is_active_page('notifications.php') ?>" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.75rem 1.5rem; color: var(--text-light); font-weight: 500; font-size: 0.925rem; border-left: 3px solid transparent;">
                    <span>🔔</span> <span class="nav-label">Notifications</span>
                </a>
            </li>
            <li>
                <a href="/calculator.php" class="sidebar-link <?= is_active_page('calculator.php') ?>" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.75rem 1.5rem; color: var(--text-light); font-weight: 500; font-size: 0.925rem; border-left: 3px solid transparent;">
                    <span>🧮</span> <span class="nav-label">Cost Calculator</span>
                </a>
            </li>
        </ul>
    </div>

    <div style="padding: 1rem 1.5rem; border-top: 1px solid rgba(255, 255, 255, 0.08);">
        <a href="/login.php" style="display: flex; align-items: center; gap: 0.75rem; color: #ef4444; font-weight: 600; font-size: 0.9rem; text-decoration: none;">
            <span>🚪</span> <span class="nav-label">Logout</span>
        </a>
    </div>
</aside>

<style>
.sidebar-link:hover, .sidebar-link.active {
    color: #ffffff !important;
    background: rgba(0, 209, 118, 0.1) !important;
    border-left-color: var(--primary) !important;
}
</style>
