/**
 * Main App Script - Smart EV Route & Demand Platform
 * 100% Dynamic Engine (Starts from 0, tracks live user actions)
 */

window.SMARTEV_CONFIG = {
    API_BASE: 'https://smartev-1.onrender.com/api',
    BACKEND_URL: 'https://smartev-1.onrender.com',
    NEO4J_URI: 'neo4j+s://355200dd.databases.neo4j.io'
};

// Dynamic Data Store Manager
window.SmartEVData = {
    getUser: function() {
        const stored = localStorage.getItem('smartev_user');
        if (stored) {
            try { return JSON.parse(stored); } catch(e) {}
        }
        return {
            name: 'Dhanya Sakthi',
            email: 'dhanya.sakthi@gmail.com',
            role: 'USER',
            evModel: 'Tata Nexon EV Max',
            capacity: 40.5,
            soc: 68,
            efficiency: 0.14
        };
    },

    getTrips: function() {
        const trips = localStorage.getItem('smartev_trips');
        return trips ? JSON.parse(trips) : [];
    },

    addTrip: function(trip) {
        const trips = this.getTrips();
        trips.unshift({
            id: 'TRIP-' + (Date.now().toString().slice(-4)),
            date: new Date().toISOString().split('T')[0],
            origin: trip.origin || 'Coimbatore',
            destination: trip.destination || 'Salem',
            distance: parseFloat(trip.distance || 0),
            energy: parseFloat(trip.energy || 0),
            cost: parseFloat(trip.cost || 0),
            station: trip.station || 'Erode Green Fast Hub',
            stops: trip.stops || 1,
            status: 'COMPLETED'
        });
        localStorage.setItem('smartev_trips', JSON.stringify(trips));
        this.updateDashboardMetrics();
    },

    clearAllDataToZero: function() {
        localStorage.removeItem('smartev_trips');
        window.showToast('All journey statistics reset to 0!', 'info');
        setTimeout(() => window.location.reload(), 600);
    },

    getMetrics: function() {
        const trips = this.getTrips();
        let totalDistance = 0;
        let totalEnergy = 0;
        let totalCost = 0;

        trips.forEach(t => {
            totalDistance += parseFloat(t.distance || 0);
            totalEnergy += parseFloat(t.energy || 0);
            totalCost += parseFloat(t.cost || 0);
        });

        return {
            totalTrips: trips.length,
            totalDistance: totalDistance.toFixed(1),
            totalEnergy: totalEnergy.toFixed(1),
            totalCost: totalCost.toFixed(2)
        };
    },

    updateDashboardMetrics: function() {
        const metrics = this.getMetrics();
        const tripEl = document.getElementById('statTotalTrips');
        const distEl = document.getElementById('statTotalDistance');
        const energyEl = document.getElementById('statTotalEnergy');
        const costEl = document.getElementById('statTotalCost');

        if (tripEl) tripEl.innerText = metrics.totalTrips;
        if (distEl) distEl.innerText = `${metrics.totalDistance} km`;
        if (energyEl) energyEl.innerText = `${metrics.totalEnergy} kWh`;
        if (costEl) costEl.innerText = `₹${metrics.totalCost}`;
    }
};

document.addEventListener('DOMContentLoaded', () => {
    // Sidebar Collapse Handler
    const sidebar = document.getElementById('appSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            document.body.classList.toggle('body-collapsed');
            sidebar.classList.toggle('collapsed');
        });
    }

    if (mobileMenuBtn && sidebar) {
        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }

    // Modal Manager
    window.openModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('show');
            modal.style.display = 'flex';
        }
    };

    window.closeModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('show');
            modal.style.display = 'none';
        }
    };

    // Close modal on backdrop click
    document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
        backdrop.addEventListener('click', (e) => {
            if (e.target === backdrop) {
                backdrop.classList.remove('show');
            }
        });
    });

    // Toast Notification Maker
    window.showToast = function(message, type = 'success') {
        let container = document.querySelector('.toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container';
            container.style.cssText = 'position:fixed;bottom:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:10px;';
            document.body.appendChild(container);
        }

        const iconMap = {
            success: '⚡',
            warning: '⚠️',
            danger: '🚨',
            info: 'ℹ️'
        };

        const bgMap = {
            success: '#10b981',
            warning: '#f59e0b',
            danger: '#ef4444',
            info: '#3b82f6'
        };

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.style.cssText = `background:#0a0f1d; color:#ffffff; border-left:4px solid ${bgMap[type] || '#10b981'}; padding:12px 18px; border-radius:8px; box-shadow:0 10px 15px -3px rgba(0,0,0,0.4); display:flex; align-items:center; gap:12px; min-width:280px; max-width:400px; animation: slideIn 0.3s ease;`;
        toast.innerHTML = `
            <span style="font-size: 1.25rem;">${iconMap[type] || '⚡'}</span>
            <div style="flex:1;">
                <p style="margin:0; font-size:0.85rem; font-weight:600; color:#ffffff;">${message}</p>
            </div>
            <button onclick="this.parentElement.remove()" style="background:none;border:none;color:#94a3b8;cursor:pointer;font-size:1.1rem;">&times;</button>
        `;

        container.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100%)';
            toast.style.transition = 'all 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3500);
    };

    // Initialize metrics on page load
    window.SmartEVData.updateDashboardMetrics();
});
