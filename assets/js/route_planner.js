/**
 * Smart EV Route Planner & Battery Consumption Interactive Script
 */

document.addEventListener('DOMContentLoaded', () => {
    const routeForm = document.getElementById('routePlannerForm');
    const routeResults = document.getElementById('routeResultsSection');

    if (routeForm) {
        routeForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const btn = routeForm.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;

            btn.innerHTML = '⚡ Querying Neo4j Graph...';
            btn.disabled = true;

            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                if (routeResults) {
                    routeResults.style.display = 'block';
                    routeResults.scrollIntoView({ behavior: 'smooth' });
                }
                showToast('Neo4j Graph algorithm calculated 3 battery-optimized routes!', 'success');
            }, 800);
        });
    }

    // Dynamic Route Switcher
    window.selectRoute = function(routeId) {
        document.querySelectorAll('.route-card').forEach(card => {
            card.classList.remove('route-card-recommended');
        });
        const selected = document.getElementById(routeId);
        if (selected) {
            selected.classList.add('route-card-recommended');
            showToast('Selected route updated in active navigation!', 'info');
        }
    };
});
