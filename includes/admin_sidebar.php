<!-- Admin Navigation Sidebar -->
<aside class="sidebar" id="appSidebar" style="position: fixed; top: 0; left: 0; bottom: 0; width: var(--sidebar-width); background: var(--navy-dark); color: var(--text-white); z-index: 1100; transition: var(--transition); display: flex; flex-direction: column; border-right: 1px solid var(--navy-light);">
    <div style="padding: 1.5rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
        <a href="/admin_dashboard.php" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none;">
            <div style="width: 38px; height: 38px; background: #3b82f6; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; color: #ffffff; font-weight: bold;">⚙️</div>
            <div class="sidebar-brand-text">
                <span style="font-family: var(--font-heading); font-weight: 800; font-size: 1.15rem; color: #ffffff;">Admin Control</span>
                <span style="display: block; font-size: 0.65rem; color: #38bdf8; font-weight: 700; text-transform: uppercase;">Neo4j Network Engine</span>
            </div>
        </a>
        <button id="sidebarToggle" style="background: none; border: none; color: var(--text-light); cursor: pointer; font-size: 1.2rem;">◀</button>
    </div>

    <div style="padding: 1rem 0; flex: 1; overflow-y: auto;">
        <div style="padding: 0 1.25rem 0.5rem 1.25rem; font-size: 0.7rem; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.8px;">Admin Console</div>

        <ul style="list-style: none; margin: 0; padding: 0;">
            <li>
                <a href="/admin_dashboard.php" class="sidebar-link <?= is_active_page('admin_dashboard.php') ?>" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.75rem 1.5rem; color: var(--text-light); font-weight: 500; font-size: 0.925rem; border-left: 3px solid transparent;">
                    <span>📊</span> <span class="nav-label">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="/admin_users.php" class="sidebar-link <?= is_active_page('admin_users.php') ?>" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.75rem 1.5rem; color: var(--text-light); font-weight: 500; font-size: 0.925rem; border-left: 3px solid transparent;">
                    <span>👥</span> <span class="nav-label">User Management</span>
                </a>
            </li>
            <li>
                <a href="/admin_evs.php" class="sidebar-link <?= is_active_page('admin_evs.php') ?>" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.75rem 1.5rem; color: var(--text-light); font-weight: 500; font-size: 0.925rem; border-left: 3px solid transparent;">
                    <span>🚘</span> <span class="nav-label">EV Profiles</span>
                </a>
            </li>
            <li>
                <a href="/admin_stations.php" class="sidebar-link <?= is_active_page('admin_stations.php') ?>" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.75rem 1.5rem; color: var(--text-light); font-weight: 500; font-size: 0.925rem; border-left: 3px solid transparent;">
                    <span>🔌</span> <span class="nav-label">Station Hubs</span>
                </a>
            </li>
            <li>
                <a href="/admin_chargers.php" class="sidebar-link <?= is_active_page('admin_chargers.php') ?>" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.75rem 1.5rem; color: var(--text-light); font-weight: 500; font-size: 0.925rem; border-left: 3px solid transparent;">
                    <span>⚡</span> <span class="nav-label">Charger Units</span>
                </a>
            </li>
            <li>
                <a href="/admin_road_network.php" class="sidebar-link <?= is_active_page('admin_road_network.php') ?>" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.75rem 1.5rem; color: var(--text-light); font-weight: 500; font-size: 0.925rem; border-left: 3px solid transparent;">
                    <span>🛣️</span> <span class="nav-label">Road & Graph Network</span>
                </a>
            </li>
            <li>
                <a href="/admin_demand.php" class="sidebar-link <?= is_active_page('admin_demand.php') ?>" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.75rem 1.5rem; color: var(--text-light); font-weight: 500; font-size: 0.925rem; border-left: 3px solid transparent;">
                    <span>📈</span> <span class="nav-label">Demand Analytics</span>
                </a>
            </li>
            <li>
                <a href="/admin_reports.php" class="sidebar-link <?= is_active_page('admin_reports.php') ?>" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.75rem 1.5rem; color: var(--text-light); font-weight: 500; font-size: 0.925rem; border-left: 3px solid transparent;">
                    <span>📄</span> <span class="nav-label">Report Generation</span>
                </a>
            </li>
            <li>
                <a href="/graph.php" class="sidebar-link <?= is_active_page('graph.php') ?>" style="display: flex; align-items: center; gap: 0.85rem; padding: 0.75rem 1.5rem; color: var(--text-light); font-weight: 500; font-size: 0.925rem; border-left: 3px solid transparent;">
                    <span>🌐</span> <span class="nav-label">Neo4j Explorer</span>
                </a>
            </li>
        </ul>
    </div>

    <div style="padding: 1rem 1.5rem; border-top: 1px solid rgba(255, 255, 255, 0.08);">
        <a href="/admin_login.php" style="display: flex; align-items: center; gap: 0.75rem; color: #ef4444; font-weight: 600; font-size: 0.9rem; text-decoration: none;">
            <span>🚪</span> <span class="nav-label">Admin Logout</span>
        </a>
    </div>
</aside>
