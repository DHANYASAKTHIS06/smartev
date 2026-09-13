<!-- Public Landing Top Navbar -->
<nav class="public-navbar" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border-color); position: sticky; top: 0; z-index: 1000; padding: 1rem 2rem;">
    <div style="max-width: 1300px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between;">
        <a href="/index.php" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none;">
            <div style="width: 40px; height: 40px; background: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: var(--navy-dark); font-weight: bold; box-shadow: var(--shadow-glow);">
                ⚡
            </div>
            <div>
                <span style="font-family: var(--font-heading); font-weight: 800; font-size: 1.25rem; color: var(--text-main); letter-spacing: -0.5px;">EV-SmartRoute</span>
                <span style="display: block; font-size: 0.65rem; color: var(--primary-hover); font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px;">Neo4j Graph Powered</span>
            </div>
        </a>

        <div style="display: flex; align-items: center; gap: 2rem;">
            <a href="/index.php#features" style="color: var(--text-main); font-weight: 500; font-size: 0.95rem;">Features</a>
            <a href="/index.php#how-it-works" style="color: var(--text-main); font-weight: 500; font-size: 0.95rem;">How It Works</a>
            <a href="/stations.php" style="color: var(--text-main); font-weight: 500; font-size: 0.95rem;">Charging Stations</a>
            <a href="/graph.php" style="color: var(--text-main); font-weight: 500; font-size: 0.95rem;">Network Graph</a>
        </div>

        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <a href="/login.php" class="btn btn-outline btn-sm">Login</a>
            <a href="/register.php" class="btn btn-primary btn-sm">Register Account</a>
            <a href="/admin_login.php" class="btn btn-secondary btn-sm" style="background: var(--navy-light);">Admin Portal</a>
        </div>
    </div>
</nav>
