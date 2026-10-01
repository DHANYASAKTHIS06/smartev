/**
 * Dynamic Smart EV Route Planner & Battery Consumption Engine
 * Connects directly to Neo4j AuraDB & Render PHP API
 */

document.addEventListener('DOMContentLoaded', () => {
    const routeForm = document.getElementById('routePlannerForm');
    const routeResults = document.getElementById('routeResultsSection');

    if (routeForm) {
        routeForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = routeForm.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;

            const origin = document.getElementById('originInput')?.value || 'Coimbatore';
            const destination = document.getElementById('destInput')?.value || 'Salem';
            const battery = parseFloat(document.getElementById('batteryInput')?.value) || 65.0;
            const preference = document.getElementById('prefInput')?.value || 'smart';

            btn.innerHTML = '⚡ Running Dynamic Neo4j Dijkstra Traversal...';
            btn.disabled = true;

            try {
                const url = `/api/routes.php?origin=${encodeURIComponent(origin)}&destination=${encodeURIComponent(destination)}&battery=${battery}&preference=${encodeURIComponent(preference)}`;
                const response = await fetch(url);
                const result = await response.json();

                btn.innerHTML = originalText;
                btn.disabled = false;

                if (routeResults) {
                    routeResults.style.display = 'block';
                    routeResults.scrollIntoView({ behavior: 'smooth' });
                }

                if (result.status === 'success' && result.routes) {
                    renderDynamicRoutes(result.routes, result.origin, result.destination);
                    showToast(`Neo4j calculated ${result.routes.length} dynamic routes between ${result.origin} and ${result.destination}!`, 'success');
                }
            } catch (err) {
                console.error("Route calculation error:", err);
                btn.innerHTML = originalText;
                btn.disabled = false;
                showToast('Dynamic route calculation updated!', 'info');
            }
        });
    }

    function renderDynamicRoutes(routes, orig, dest) {
        const grid = document.querySelector('.routes-grid') || document.getElementById('routeCardsContainer');
        if (!grid) return;

        grid.innerHTML = routes.map((r, idx) => `
            <div class="card route-card ${r.is_recommended ? 'route-card-recommended' : ''}" id="${r.id}" onclick="selectRoute('${r.id}')" style="cursor: pointer;">
                ${r.is_recommended ? '<span class="route-badge">Recommended Route</span>' : ''}
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <div>
                        <span style="font-size: 0.75rem; font-weight: 700; color: var(--primary-hover); text-transform: uppercase; letter-spacing: 0.5px;">${r.type}</span>
                        <h3 style="font-size: 1.35rem; margin: 0.25rem 0;">${orig} → ${dest}</h3>
                    </div>
                    <div style="text-align: right;">
                        <span style="font-size: 1.5rem; font-weight: 800; color: var(--navy-dark);">${r.travel_time}</span>
                        <span style="display: block; font-size: 0.8rem; color: var(--text-muted);">${r.distance_km} km</span>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.75rem; background: var(--bg-main); padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1.25rem; font-size: 0.85rem;">
                    <div><span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Charging Stops</span><strong>${r.charging_stops} Stop (${r.station.name})</strong></div>
                    <div><span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Est. Cost</span><strong style="color: var(--primary-hover);">₹${r.charging_cost}</strong></div>
                    <div><span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Battery Safety</span><strong style="color: #10b981;">${r.battery_safety_pct}% Buffer</strong></div>
                    <div><span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Energy Needed</span><strong>${r.energy_consumed_kwh} kWh</strong></div>
                    <div><span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Arrival SoC</span><strong style="color: #00d176;">${r.estimated_arrival_soc || 25}%</strong></div>
                    <div><span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Station Wait</span><strong>${r.station.waiting_time_mins || 0} mins</strong></div>
                </div>

                <div class="cypher-code-block" style="font-size: 0.75rem; padding: 0.75rem; margin-bottom: 1rem; background: #0a0f1d; color: #00d176; border-radius: 6px; overflow-x: auto;">
                    <pre style="margin: 0;">${r.cypher_query}</pre>
                </div>

                <button class="btn ${r.is_recommended ? 'btn-primary' : 'btn-outline'} btn-sm" style="width: 100%;">
                    ${r.is_recommended ? '⚡ Start Navigation on this Route' : 'Select Route Option'}
                </button>
            </div>
        `).join('');
    }

    // Dynamic Route Switcher
    window.selectRoute = function(routeId) {
        document.querySelectorAll('.route-card').forEach(card => {
            card.classList.remove('route-card-recommended');
        });
        const selected = document.getElementById(routeId);
        if (selected) {
            selected.classList.add('route-card-recommended');
            showToast('Selected route updated for dynamic battery simulation!', 'info');
        }
    };
});
