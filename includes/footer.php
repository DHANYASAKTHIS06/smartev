<!-- Shared Application Footer -->
<footer style="margin-top: auto; padding: 1.5rem 2rem; background: var(--bg-card); border-top: 1px solid var(--border-color); color: var(--text-muted); font-size: 0.85rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
    <div>
        <strong>Smart EV Charging Network Route Optimization & Demand Management</strong> &copy; <?= date('Y') ?>
    </div>
    <div style="display: flex; align-items: center; gap: 1.5rem;">
        <span class="badge badge-primary">Neo4j v5.12 Connected</span>
        <span>Graph Engine Active</span>
    </div>
</footer>

<!-- Core Application Scripts -->
<script src="/assets/js/main.js"></script>
<script src="/assets/js/route_planner.js"></script>
<script src="/assets/js/demand_chart.js"></script>
<script src="/assets/js/graph_viz.js"></script>
</body>
</html>
