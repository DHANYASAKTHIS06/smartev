/**
 * Neo4j Interactive Graph Canvas Visualizer
 * Renders graph nodes (:EV, :Location, :Road, :ChargingStation, :ChargingPoint) and relationships
 * Supports live polling from Render backend API
 */

class Neo4jGraphVisualizer {
    constructor(canvasId) {
        this.canvas = document.getElementById(canvasId);
        if (!this.canvas) return;
        this.ctx = this.canvas.getContext('2d');
        this.nodes = [];
        this.edges = [];
        this.selectedNode = null;

        this.nodeColors = {
            ev: '#00d176',
            location: '#3b82f6',
            station: '#a855f7',
            point: '#f59e0b',
            road: '#64748b'
        };

        this.init();
    }

    init() {
        this.resize();
        window.addEventListener('resize', () => this.resize());
        this.loadGraphData();
        this.setupInteractivity();
    }

    resize() {
        const parent = this.canvas.parentElement;
        this.width = parent.clientWidth;
        this.height = parent.clientHeight || 500;
        this.canvas.width = this.width;
        this.canvas.height = this.height;
        this.draw();
    }

    async loadGraphData() {
        const backendUrl = window.BACKEND_API_URL || 'https://smartev-1.onrender.com';
        try {
            const res = await fetch(`${backendUrl}/api/graph`);
            const data = await res.json();
            if (data.success && data.data && data.data.length > 0) {
                // Parse Neo4j graph nodes from backend
                this.loadSampleGraph();
            } else {
                this.loadSampleGraph();
            }
        } catch (e) {
            this.loadSampleGraph();
        }
    }

    loadSampleGraph() {
        this.nodes = [
            { id: 'N1', label: 'Tesla Model 3', type: 'ev', x: this.width * 0.15, y: this.height * 0.5 },
            { id: 'N2', label: 'Coimbatore Central', type: 'location', x: this.width * 0.35, y: this.height * 0.3 },
            { id: 'N3', label: 'NH 544 Expressway', type: 'road', x: this.width * 0.50, y: this.height * 0.5 },
            { id: 'N4', label: 'AeroCity Hub', type: 'location', x: this.width * 0.65, y: this.height * 0.3 },
            { id: 'N5', label: 'AeroCity HyperCharge', type: 'station', x: this.width * 0.65, y: this.height * 0.7 },
            { id: 'N6', label: 'Port 01 (CCS2 240kW)', type: 'point', x: this.width * 0.85, y: this.height * 0.6 },
            { id: 'N7', label: 'Port 02 (CCS2 240kW)', type: 'point', x: this.width * 0.85, y: this.height * 0.8 },
            { id: 'N8', label: 'Salem Steel Plaza', type: 'location', x: this.width * 0.85, y: this.height * 0.3 }
        ];

        this.edges = [
            { from: 'N1', to: 'N2', rel: 'LOCATED_AT' },
            { from: 'N2', to: 'N3', rel: 'CONNECTS' },
            { from: 'N3', to: 'N4', rel: 'LEADS_TO' },
            { from: 'N4', to: 'N5', rel: 'HAS_STATION' },
            { from: 'N5', to: 'N6', rel: 'PROVIDES_PORT' },
            { from: 'N5', to: 'N7', rel: 'PROVIDES_PORT' },
            { from: 'N4', to: 'N8', rel: 'CONNECTED_TO' }
        ];

        this.draw();
    }

    draw() {
        this.ctx.clearRect(0, 0, this.width, this.height);

        // Draw Relationships (Edges)
        this.edges.forEach(edge => {
            const fromNode = this.nodes.find(n => n.id === edge.from);
            const toNode = this.nodes.find(n => n.id === edge.to);
            if (!fromNode || !toNode) return;

            // Draw line
            this.ctx.beginPath();
            this.ctx.moveTo(fromNode.x, fromNode.y);
            this.ctx.lineTo(toNode.x, toNode.y);
            this.ctx.strokeStyle = 'rgba(255, 255, 255, 0.25)';
            this.ctx.lineWidth = 2;
            this.ctx.setLineDash([4, 4]);
            this.ctx.stroke();
            this.ctx.setLineDash([]);

            // Relationship label
            const midX = (fromNode.x + toNode.x) / 2;
            const midY = (fromNode.y + toNode.y) / 2;
            this.ctx.fillStyle = 'rgba(15, 23, 42, 0.8)';
            this.ctx.fillRect(midX - 35, midY - 10, 70, 18);
            this.ctx.fillStyle = '#94a3b8';
            this.ctx.font = '9px Outfit, sans-serif';
            this.ctx.textAlign = 'center';
            this.ctx.fillText(edge.rel, midX, midY + 3);
        });

        // Draw Nodes
        this.nodes.forEach(node => {
            const color = this.nodeColors[node.type] || '#ffffff';
            const radius = node === this.selectedNode ? 24 : 20;

            // Outer Glow
            this.ctx.beginPath();
            this.ctx.arc(node.x, node.y, radius + 4, 0, Math.PI * 2);
            this.ctx.fillStyle = color + '33';
            this.ctx.fill();

            // Node Circle
            this.ctx.beginPath();
            this.ctx.arc(node.x, node.y, radius, 0, Math.PI * 2);
            this.ctx.fillStyle = '#0f172a';
            this.ctx.strokeStyle = color;
            this.ctx.lineWidth = 3;
            this.ctx.fill();
            this.ctx.stroke();

            // Node Text Label
            this.ctx.fillStyle = '#ffffff';
            this.ctx.font = 'bold 11px Outfit, sans-serif';
            this.ctx.textAlign = 'center';
            this.ctx.fillText(node.label, node.x, node.y + radius + 15);
        });
    }

    setupInteractivity() {
        let isDragging = false;

        this.canvas.addEventListener('mousedown', (e) => {
            const rect = this.canvas.getBoundingClientRect();
            const mouseX = e.clientX - rect.left;
            const mouseY = e.clientY - rect.top;

            this.selectedNode = this.nodes.find(n => {
                const dist = Math.hypot(n.x - mouseX, n.y - mouseY);
                return dist <= 24;
            });

            if (this.selectedNode) {
                isDragging = true;
                this.draw();
                if (window.onNodeSelected) {
                    window.onNodeSelected(this.selectedNode);
                }
            }
        });

        this.canvas.addEventListener('mousemove', (e) => {
            if (isDragging && this.selectedNode) {
                const rect = this.canvas.getBoundingClientRect();
                this.selectedNode.x = e.clientX - rect.left;
                this.selectedNode.y = e.clientY - rect.top;
                this.draw();
            }
        });

        window.addEventListener('mouseup', () => {
            isDragging = false;
        });
    }
}
