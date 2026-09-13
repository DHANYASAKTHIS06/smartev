# Smart EV Charging Network Route Optimization & Predictive Demand Management

> **Powered by PHP & Neo4j Graph Database**

An intelligent Electric Vehicle (EV) journey planning, battery awareness, predictive station demand management, dynamic route replanning, and graph topology visualization platform.

---

## ⚡ Deployment to Vercel (Step-by-Step)

This project includes a pre-configured `vercel.json` file using the community `vercel-php` runtime for serverless execution.

### Method 1: Deploy via Vercel CLI (Fastest)

1. Open your terminal in the project directory:
   ```bash
   cd project/oss
   ```
2. Run Vercel CLI:
   ```bash
   npx vercel
   ```
3. Follow the prompts (press Enter for default settings). Vercel will automatically detect `vercel.json` and deploy your application.

---

### Method 2: Deploy via GitHub & Vercel Dashboard

1. Initialize Git and commit code:
   ```bash
   git init
   git add .
   git commit -m "Initial commit of Smart EV RouteOpt platform"
   ```
2. Push your code to GitHub / GitLab / Bitbucket.
3. Log in to [Vercel Dashboard](https://vercel.com).
4. Click **Add New Project** ➔ Select your GitHub Repository.
5. Leave the framework pre-set as **Other**.
6. Click **Deploy**. Vercel will automatically build and deploy all PHP views, CSS/JS assets, and API routes!

---

## 💻 Local Testing & Execution

To test locally on your computer:

```bash
# Using standard PHP built-in web server:
php -S localhost:8000
```
Then visit `http://localhost:8000` in your web browser.

---

## 🚀 Key Features Implemented

- ⚡ **Smart Route Planner**: Graph shortest-path calculation comparing Fastest, Cheapest, and Smart Recommended routes.
- 🔋 **Battery-Aware Routing**: Real-time State of Charge (SOC) tracking and low-battery warning alerts.
- 📈 **Predictive Demand Analytics**: AI 24-hour hourly occupancy forecasting with peak congestion alerts.
- 🔄 **Dynamic Route Replanning**: Real-time grid failure rerouting and alternative comparison matrix.
- 🌐 **Neo4j Network Graph**: Interactive canvas displaying `:EV`, `:Location`, `:Road`, `:ChargingStation`, and `:ChargingPoint` nodes.
- ⚙️ **Admin Suite**: User management, EV model profiles, station hub management, charger units, and report generation.
