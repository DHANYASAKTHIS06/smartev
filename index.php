<?php
$pageTitle = "Smart EV Route Optimization & Predictive Demand Management";
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<!-- Hero Section -->
<section style="padding: 5rem 2rem 4rem 2rem; background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%); position: relative; overflow: hidden;">
    <div style="max-width: 1300px; margin: 0 auto; display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 3rem; align-items: center;">
        <div>
            <div class="badge badge-primary" style="margin-bottom: 1.25rem; font-weight: 700; font-size: 0.85rem;">
                ⚡ Powered by Neo4j Graph Database & AI Analytics
            </div>
            <h1 style="font-size: 3.5rem; line-height: 1.1; color: var(--navy-dark); margin-bottom: 1.25rem; letter-spacing: -1px;">
                Drive Smarter.<br>
                <span style="color: var(--primary-hover);">Charge Better.</span><br>
                Reach Further.
            </h1>
            <p style="font-size: 1.2rem; color: var(--text-muted); margin-bottom: 2.25rem; max-width: 580px; line-height: 1.6;">
                Intelligent EV route optimization with smart charging recommendations and predictive station demand management.
            </p>

            <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                <a href="/route_planner.php" class="btn btn-primary btn-lg">
                    🗺️ Plan My Journey
                </a>
                <a href="/stations.php" class="btn btn-outline btn-lg">
                    🔌 Explore Charging Stations
                </a>
            </div>
        </div>

        <!-- Right Side Visual Network Graphic -->
        <div style="position: relative;">
            <div style="background: var(--navy-dark); border-radius: var(--radius-xl); padding: 2rem; box-shadow: var(--shadow-lg); border: 1px solid var(--navy-light); color: #ffffff;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #ef4444;"></span>
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #f59e0b;"></span>
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #10b981;"></span>
                    </div>
                    <span style="font-family: monospace; font-size: 0.8rem; color: var(--primary);">CYPHER GRAPH ROUTE PIPELINE</span>
                </div>

                <!-- Mock SVG Visual -->
                <svg viewBox="0 0 400 240" style="width: 100%; height: auto;">
                    <!-- Graph Path Edges -->
                    <path d="M 50 120 Q 120 40 200 80 T 350 120" stroke="#00d176" stroke-width="4" fill="none" stroke-dasharray="6,6" />
                    <path d="M 50 120 Q 140 200 240 180 T 350 120" stroke="#334155" stroke-width="3" fill="none" />

                    <!-- Location Nodes -->
                    <circle cx="50" cy="120" r="16" fill="#0f172a" stroke="#00d176" stroke-width="3" />
                    <text x="50" y="124" fill="#ffffff" font-size="10" font-weight="bold" text-anchor="middle">A</text>

                    <!-- Charging Station Node -->
                    <circle cx="200" cy="80" r="22" fill="#0f172a" stroke="#00d176" stroke-width="4" />
                    <text x="200" y="85" fill="#00d176" font-size="16" text-anchor="middle">⚡</text>

                    <circle cx="350" cy="120" r="16" fill="#0f172a" stroke="#3b82f6" stroke-width="3" />
                    <text x="350" y="124" fill="#ffffff" font-size="10" font-weight="bold" text-anchor="middle">B</text>

                    <!-- Tooltip Card Overlay -->
                    <g transform="translate(140, 115)">
                        <rect width="120" height="42" rx="8" fill="#1e293b" stroke="#00d176" stroke-width="1.5" />
                        <text x="60" y="18" fill="#ffffff" font-size="10" font-weight="bold" text-anchor="middle">AeroCity Hub</text>
                        <text x="60" y="32" fill="#00d176" font-size="9" text-anchor="middle">240 kW • 6 Ports Free</text>
                    </g>
                </svg>

                <div style="display: flex; justify-content: space-between; margin-top: 1rem; background: rgba(0,0,0,0.3); padding: 0.75rem 1rem; border-radius: var(--radius-md); font-size: 0.85rem;">
                    <span>Battery Status: <strong style="color: var(--primary);">68%</strong></span>
                    <span>Range Remaining: <strong style="color: #ffffff;">214 km</strong></span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Hero Statistics Cards -->
<section style="padding: 2rem; max-width: 1300px; margin: -2rem auto 4rem auto; position: relative; z-index: 10;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem;">
        <div class="card" style="text-align: center; border-top: 4px solid var(--primary);">
            <div style="font-size: 2.5rem; font-weight: 800; font-family: var(--font-heading); color: var(--navy-dark);">250+</div>
            <div style="font-weight: 600; color: var(--text-muted);">Charging Stations</div>
        </div>

        <div class="card" style="text-align: center; border-top: 4px solid var(--primary);">
            <div style="font-size: 2.5rem; font-weight: 800; font-family: var(--font-heading); color: var(--navy-dark);">850+</div>
            <div style="font-weight: 600; color: var(--text-muted);">Charging Points</div>
        </div>

        <div class="card" style="text-align: center; border-top: 4px solid var(--primary);">
            <div style="font-size: 2.5rem; font-weight: 800; font-family: var(--font-heading); color: var(--navy-dark);">12K+</div>
            <div style="font-weight: 600; color: var(--text-muted);">Successful Trips</div>
        </div>

        <div class="card" style="text-align: center; border-top: 4px solid var(--primary);">
            <div style="font-size: 2.5rem; font-weight: 800; font-family: var(--font-heading); color: var(--navy-dark);">98%</div>
            <div style="font-weight: 600; color: var(--text-muted);">Route Accuracy</div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section id="how-it-works" style="padding: 4rem 2rem; background: #ffffff;">
    <div style="max-width: 1300px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 3.5rem;">
            <div class="badge badge-primary" style="margin-bottom: 0.5rem;">Seamless Journey</div>
            <h2 style="font-size: 2.4rem; color: var(--navy-dark);">How It Works</h2>
            <p style="color: var(--text-muted);">Four simple steps to anxiety-free EV travel</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
            <div class="card" style="text-align: center;">
                <div style="width: 60px; height: 60px; background: var(--primary-light); color: var(--primary-hover); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin: 0 auto 1.25rem auto;">1</div>
                <h3 style="font-size: 1.2rem; margin-bottom: 0.5rem;">Enter Journey</h3>
                <p style="font-size: 0.9rem; color: var(--text-muted);">Specify your starting location and destination.</p>
            </div>

            <div class="card" style="text-align: center;">
                <div style="width: 60px; height: 60px; background: var(--primary-light); color: var(--primary-hover); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin: 0 auto 1.25rem auto;">2</div>
                <h3 style="font-size: 1.2rem; margin-bottom: 0.5rem;">Analyze EV Battery</h3>
                <p style="font-size: 0.9rem; color: var(--text-muted);">System evaluates initial SOC %, EV model capacity & efficiency.</p>
            </div>

            <div class="card" style="text-align: center;">
                <div style="width: 60px; height: 60px; background: var(--primary-light); color: var(--primary-hover); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin: 0 auto 1.25rem auto;">3</div>
                <h3 style="font-size: 1.2rem; margin-bottom: 0.5rem;">Find Smart Stops</h3>
                <p style="font-size: 0.9rem; color: var(--text-muted);">Neo4j graph algorithm identifies optimal fast charging hubs.</p>
            </div>

            <div class="card" style="text-align: center;">
                <div style="width: 60px; height: 60px; background: var(--primary-light); color: var(--primary-hover); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; margin: 0 auto 1.25rem auto;">4</div>
                <h3 style="font-size: 1.2rem; margin-bottom: 0.5rem;">Get Optimized Route</h3>
                <p style="font-size: 0.9rem; color: var(--text-muted);">Receive complete route with minimal wait times & lowest cost.</p>
            </div>
        </div>
    </div>
</section>

<!-- Key Features Section -->
<section id="features" style="padding: 5rem 2rem; background: var(--bg-main);">
    <div style="max-width: 1300px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 3.5rem;">
            <div class="badge badge-primary" style="margin-bottom: 0.5rem;">Intelligent Platform</div>
            <h2 style="font-size: 2.4rem; color: var(--navy-dark);">Key Features</h2>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 2rem;">
            <div class="card">
                <div style="font-size: 2.2rem; margin-bottom: 1rem;">🔋</div>
                <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem;">Battery-Aware Routing</h3>
                <p style="font-size: 0.925rem; color: var(--text-muted);">Real-time battery consumption projection considering terrain, speed, and safety reserve margins.</p>
            </div>

            <div class="card">
                <div style="font-size: 2.2rem; margin-bottom: 1rem;">⚡</div>
                <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem;">Smart Station Recommendation</h3>
                <p style="font-size: 0.925rem; color: var(--text-muted);">Matches your EV connector type, maximum kW intake speed, and amenity preferences.</p>
            </div>

            <div class="card">
                <div style="font-size: 2.2rem; margin-bottom: 1rem;">🔄</div>
                <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem;">Dynamic Route Replanning</h3>
                <p style="font-size: 0.925rem; color: var(--text-muted);">Automatically reroutes your EV if a scheduled charging station experiences sudden queue surges or downtime.</p>
            </div>

            <div class="card">
                <div style="font-size: 2.2rem; margin-bottom: 1rem;">📈</div>
                <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem;">Predictive Demand Analytics</h3>
                <p style="font-size: 0.925rem; color: var(--text-muted);">AI time-series modeling forecasts hourly station congestion so you can charge without waiting.</p>
            </div>

            <div class="card">
                <div style="font-size: 2.2rem; margin-bottom: 1rem;">💰</div>
                <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem;">Charging Cost Optimization</h3>
                <p style="font-size: 0.925rem; color: var(--text-muted);">Compare electricity rates per kWh to find the most economical journey option.</p>
            </div>

            <div class="card">
                <div style="font-size: 2.2rem; margin-bottom: 1rem;">🌐</div>
                <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem;">EV Network Graph Visualization</h3>
                <p style="font-size: 0.925rem; color: var(--text-muted);">Interactive Neo4j graph explorer displaying complex relationships between roads, chargers, and EVs.</p>
            </div>
        </div>
    </div>
</section>

<!-- Why Our System Banner -->
<section style="padding: 5rem 2rem; background: var(--navy-dark); color: #ffffff; text-align: center;">
    <div style="max-width: 900px; margin: 0 auto;">
        <h2 style="font-size: 2.8rem; color: #ffffff; margin-bottom: 1.5rem;">
            “More than the shortest route — we find the smartest route for your EV.”
        </h2>
        <p style="font-size: 1.15rem; color: var(--text-light); margin-bottom: 2.5rem;">
            Eliminate range anxiety and station queue delays with Cypher graph shortest-path algorithms.
        </p>
        <a href="/register.php" class="btn btn-primary btn-lg">Get Started Now</a>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
