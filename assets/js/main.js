/**
 * Main App Script
 * Controls Sidebar toggling, Modals, Toast notifications, Dropdowns & UI interactions
 */

document.addEventListener('DOMContentLoaded', () => {
    // Sidebar Collapse Handler
    const sidebar = document.getElementById('appSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');

    if (sidebarToggle) {
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
        }
    };

    window.closeModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('show');
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
            document.body.appendChild(container);
        }

        const iconMap = {
            success: '⚡',
            warning: '⚠️',
            danger: '🚨',
            info: 'ℹ️'
        };

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <span style="font-size: 1.25rem;">${iconMap[type] || '⚡'}</span>
            <div style="flex:1;">
                <p style="margin:0; font-size:0.9rem; font-weight:600;">${message}</p>
            </div>
            <button onclick="this.parentElement.remove()" style="background:none;border:none;color:#94a3b8;cursor:pointer;font-size:1.1rem;">&times;</button>
        `;

        container.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100%)';
            toast.style.transition = 'all 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    };
});
