/**
 * Predictive Charging Demand 24-Hour Time-Series Renderer
 */

function renderDemandChart(canvasId, forecastData) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const dpr = window.devicePixelRatio || 1;
    
    // Scale canvas for crisp display on high DPI screens
    const rect = canvas.getBoundingClientRect();
    canvas.width = rect.width * dpr;
    canvas.height = (rect.height || 260) * dpr;
    ctx.scale(dpr, dpr);

    const width = rect.width;
    const height = rect.height || 260;
    const padding = { top: 30, right: 30, bottom: 40, left: 45 };

    const graphWidth = width - padding.left - padding.right;
    const graphHeight = height - padding.top - padding.bottom;

    ctx.clearRect(0, 0, width, height);

    // Draw Grid Lines & Y-Axis Labels
    const ySteps = 4;
    ctx.strokeStyle = '#e2e8f0';
    ctx.lineWidth = 1;
    ctx.fillStyle = '#64748b';
    ctx.font = '11px Inter, sans-serif';

    for (let i = 0; i <= ySteps; i++) {
        const val = Math.round(100 - (i * 25));
        const y = padding.top + (i * (graphHeight / ySteps));
        
        ctx.beginPath();
        ctx.moveTo(padding.left, y);
        ctx.lineTo(width - padding.right, y);
        ctx.stroke();

        ctx.fillText(val + '%', 10, y + 4);
    }

    if (!forecastData || forecastData.length === 0) return;

    const points = forecastData.map((d, index) => {
        const x = padding.left + (index * (graphWidth / (forecastData.length - 1)));
        const y = padding.top + graphHeight - ((d.demand / 100) * graphHeight);
        return { x, y, hour: d.hour, demand: d.demand };
    });

    // Draw Smooth Area Gradient
    const gradient = ctx.createLinearGradient(0, padding.top, 0, height - padding.bottom);
    gradient.addColorStop(0, 'rgba(0, 209, 118, 0.35)');
    gradient.addColorStop(1, 'rgba(0, 209, 118, 0.0)');

    ctx.beginPath();
    ctx.moveTo(points[0].x, points[0].y);
    for (let i = 1; i < points.length; i++) {
        const xc = (points[i].x + points[i - 1].x) / 2;
        const yc = (points[i].y + points[i - 1].y) / 2;
        ctx.quadraticCurveTo(points[i - 1].x, points[i - 1].y, xc, yc);
    }
    ctx.lineTo(points[points.length - 1].x, points[points.length - 1].y);
    ctx.lineTo(points[points.length - 1].x, height - padding.bottom);
    ctx.lineTo(points[0].x, height - padding.bottom);
    ctx.closePath();
    ctx.fillStyle = gradient;
    ctx.fill();

    // Draw Main Demand Curve Line
    ctx.beginPath();
    ctx.moveTo(points[0].x, points[0].y);
    for (let i = 1; i < points.length; i++) {
        const xc = (points[i].x + points[i - 1].x) / 2;
        const yc = (points[i].y + points[i - 1].y) / 2;
        ctx.quadraticCurveTo(points[i - 1].x, points[i - 1].y, xc, yc);
    }
    ctx.lineTo(points[points.length - 1].x, points[points.length - 1].y);
    ctx.strokeStyle = '#00d176';
    ctx.lineWidth = 3;
    ctx.stroke();

    // Draw Data Points & X Labels
    points.forEach((pt) => {
        ctx.beginPath();
        ctx.arc(pt.x, pt.y, 5, 0, Math.PI * 2);
        ctx.fillStyle = pt.demand > 80 ? '#ef4444' : (pt.demand > 60 ? '#f59e0b' : '#00d176');
        ctx.fill();
        ctx.strokeStyle = '#ffffff';
        ctx.lineWidth = 2;
        ctx.stroke();

        // X Label
        ctx.fillStyle = '#64748b';
        ctx.textAlign = 'center';
        ctx.fillText(pt.hour, pt.x, height - 12);
    });
}
