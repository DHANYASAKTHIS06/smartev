<?php
/**
 * Realistic Sample Datasets for Smart EV Charging Network
 * Graph nodes, Charging Stations, EV Models, Predictive Demand & Trip History
 */

return [
    'user_evs' => [
        [
            'id' => 'EV-101',
            'model' => 'Tesla Model 3 Long Range',
            'brand' => 'Tesla',
            'battery_capacity' => 75, // kWh
            'current_battery' => 68,  // %
            'max_charging_power' => 250, // kW
            'connector_type' => 'CCS2 / Type 2',
            'efficiency' => 0.160, // kWh/km
            'is_default' => true,
            'image' => 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?auto=format&fit=crop&q=80&w=400'
        ],
        [
            'id' => 'EV-102',
            'model' => 'Hyundai Ioniq 5 AWD',
            'brand' => 'Hyundai',
            'battery_capacity' => 77.4,
            'current_battery' => 45,
            'max_charging_power' => 220,
            'connector_type' => 'CCS2',
            'efficiency' => 0.178,
            'is_default' => false,
            'image' => 'https://images.unsplash.com/photo-1617788138017-80ad40651399?auto=format&fit=crop&q=80&w=400'
        ],
        [
            'id' => 'EV-103',
            'model' => 'Tata Nexon EV Max',
            'brand' => 'Tata Motors',
            'battery_capacity' => 40.5,
            'current_battery' => 82,
            'max_charging_power' => 50,
            'connector_type' => 'CCS2',
            'efficiency' => 0.135,
            'is_default' => false,
            'image' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&q=80&w=400'
        ]
    ],

    'charging_stations' => [
        [
            'id' => 'STN-001',
            'name' => 'AeroCity HyperCharge Superhub',
            'location' => 'Sector 21, AeroCity Expressway',
            'distance_km' => 3.2,
            'available_chargers' => 6,
            'total_chargers' => 8,
            'charging_speed_kw' => 240,
            'connectors' => ['CCS2', 'Type 2'],
            'price_per_kwh' => 18.5,
            'status' => 'Available',
            'status_code' => 'available',
            'current_demand_pct' => 42,
            'predicted_demand_pct' => 65,
            'estimated_wait_min' => 0,
            'rating' => 4.9,
            'amenities' => ['Café', 'Restroom', 'WiFi', 'Shopping Mall', 'Lounge'],
            'lat' => 28.5562,
            'lng' => 77.0999
        ],
        [
            'id' => 'STN-002',
            'name' => 'EcoPulse Metro Park Hub',
            'location' => 'Cyber City Phase 2',
            'distance_km' => 7.8,
            'available_chargers' => 2,
            'total_chargers' => 10,
            'charging_speed_kw' => 150,
            'connectors' => ['CCS2', 'CHAdeMO'],
            'price_per_kwh' => 16.0,
            'status' => 'Limited',
            'status_code' => 'limited',
            'current_demand_pct' => 82,
            'predicted_demand_pct' => 91,
            'estimated_wait_min' => 8,
            'rating' => 4.7,
            'amenities' => ['Restroom', 'Coffee Vending', 'ATM'],
            'lat' => 28.4950,
            'lng' => 77.0890
        ],
        [
            'id' => 'STN-003',
            'name' => 'GreenDrive Express Plaza B',
            'location' => 'Outer Ring Road, Junction 14',
            'distance_km' => 12.4,
            'available_chargers' => 0,
            'total_chargers' => 6,
            'charging_speed_kw' => 120,
            'connectors' => ['CCS2', 'Type 2'],
            'price_per_kwh' => 14.5,
            'status' => 'Busy',
            'status_code' => 'busy',
            'current_demand_pct' => 100,
            'predicted_demand_pct' => 88,
            'estimated_wait_min' => 22,
            'rating' => 4.5,
            'amenities' => ['Snack Bar', 'Air Pump'],
            'lat' => 28.6280,
            'lng' => 77.1120
        ],
        [
            'id' => 'STN-004',
            'name' => 'VoltNode Highway Oasis North',
            'location' => 'Grand Trunk Highway, KM 45',
            'distance_km' => 24.5,
            'available_chargers' => 5,
            'total_chargers' => 12,
            'charging_speed_kw' => 350,
            'connectors' => ['CCS2', 'Type 2', 'CHAdeMO'],
            'price_per_kwh' => 20.0,
            'status' => 'Available',
            'status_code' => 'available',
            'current_demand_pct' => 38,
            'predicted_demand_pct' => 45,
            'estimated_wait_min' => 0,
            'rating' => 4.95,
            'amenities' => ['Food Court', 'Work Lounge', 'Solar Roof', 'Playground'],
            'lat' => 28.7500,
            'lng' => 77.1500
        ],
        [
            'id' => 'STN-005',
            'name' => 'Zenith CleanEnergy Hub East',
            'location' => 'Tech Park Sector 62',
            'distance_km' => 15.1,
            'available_chargers' => 4,
            'total_chargers' => 6,
            'charging_speed_kw' => 60,
            'connectors' => ['Type 2'],
            'price_per_kwh' => 12.8,
            'status' => 'Available',
            'status_code' => 'available',
            'current_demand_pct' => 50,
            'predicted_demand_pct' => 62,
            'estimated_wait_min' => 0,
            'rating' => 4.3,
            'amenities' => ['Workspaces', 'Restroom'],
            'lat' => 28.6270,
            'lng' => 77.3720
        ]
    ],

    'demand_forecast' => [
        ['hour' => '8 AM', 'demand' => 35, 'queue' => 0, 'wait' => '0m', 'level' => 'Low'],
        ['hour' => '10 AM', 'demand' => 58, 'queue' => 1, 'wait' => '4m', 'level' => 'Medium'],
        ['hour' => '12 PM', 'demand' => 72, 'queue' => 3, 'wait' => '12m', 'level' => 'High'],
        ['hour' => '2 PM', 'demand' => 61, 'queue' => 2, 'wait' => '6m', 'level' => 'Medium'],
        ['hour' => '4 PM', 'demand' => 65, 'queue' => 2, 'wait' => '7m', 'level' => 'Medium'],
        ['hour' => '6 PM', 'demand' => 88, 'queue' => 5, 'wait' => '24m', 'level' => 'High'],
        ['hour' => '8 PM', 'demand' => 74, 'queue' => 3, 'wait' => '14m', 'level' => 'High'],
        ['hour' => '10 PM', 'demand' => 40, 'queue' => 0, 'wait' => '0m', 'level' => 'Low']
    ],

    'trip_history' => [
        [
            'id' => 'TRIP-9921',
            'date' => '2026-09-12',
            'start' => 'Downtown Central Plaza',
            'destination' => 'Tech Hub East',
            'distance_km' => 148,
            'charging_stops' => 1,
            'station_used' => 'AeroCity HyperCharge Superhub',
            'energy_used_kwh' => 23.6,
            'cost_inr' => 155,
            'status' => 'Completed'
        ],
        [
            'id' => 'TRIP-9840',
            'date' => '2026-09-08',
            'start' => 'North Residence',
            'destination' => 'Highland Resort',
            'distance_km' => 220,
            'charging_stops' => 2,
            'station_used' => 'VoltNode Highway Oasis',
            'energy_used_kwh' => 35.2,
            'cost_inr' => 240,
            'status' => 'Completed'
        ],
        [
            'id' => 'TRIP-9712',
            'date' => '2026-09-02',
            'start' => 'Cyber City',
            'destination' => 'Airport Terminal 3',
            'distance_km' => 45,
            'charging_stops' => 0,
            'station_used' => 'None Direct',
            'energy_used_kwh' => 7.2,
            'cost_inr' => 0,
            'status' => 'Completed'
        ]
    ],

    'neo4j_graph_nodes' => [
        ['id' => 'N1', 'label' => 'EV', 'name' => 'Tesla Model 3', 'battery' => '68%', 'type' => 'ev'],
        ['id' => 'N2', 'label' => 'Location', 'name' => 'Downtown Central', 'type' => 'location'],
        ['id' => 'N3', 'label' => 'Location', 'name' => 'AeroCity Hub', 'type' => 'location'],
        ['id' => 'N4', 'label' => 'ChargingStation', 'name' => 'AeroCity HyperCharge', 'speed' => '240 kW', 'type' => 'station'],
        ['id' => 'N5', 'label' => 'ChargingPoint', 'name' => 'Port 01 (CCS2)', 'status' => 'Available', 'type' => 'point'],
        ['id' => 'N6', 'label' => 'ChargingPoint', 'name' => 'Port 02 (CCS2)', 'status' => 'Occupied', 'type' => 'point'],
        ['id' => 'N7', 'label' => 'Location', 'name' => 'Tech Hub East', 'type' => 'location'],
        ['id' => 'N8', 'label' => 'Road', 'name' => 'Expressway Segment 4', 'dist' => '42 km', 'type' => 'road']
    ],

    'neo4j_graph_edges' => [
        ['from' => 'N1', 'to' => 'N2', 'label' => 'LOCATED_AT'],
        ['from' => 'N2', 'to' => 'N8', 'label' => 'CONNECTS'],
        ['from' => 'N8', 'to' => 'N3', 'label' => 'LEADS_TO'],
        ['from' => 'N3', 'to' => 'N4', 'label' => 'HAS_STATION'],
        ['from' => 'N4', 'to' => 'N5', 'label' => 'PROVIDES_PORT'],
        ['from' => 'N4', 'to' => 'N6', 'label' => 'PROVIDES_PORT'],
        ['from' => 'N3', 'to' => 'N7', 'label' => 'CONNECTED_TO']
    ]
];
