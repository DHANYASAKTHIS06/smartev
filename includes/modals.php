<!-- Global Reusable Modals -->

<!-- Add EV Profile Modal -->
<div class="modal-backdrop" id="addEvModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 style="font-size: 1.2rem;">⚡ Add New EV Profile</h3>
            <button class="modal-close" onclick="closeModal('addEvModal')">&times;</button>
        </div>
        <form action="/ev_profile.php" method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">EV Model / Brand</label>
                    <input type="text" name="model" class="form-control" placeholder="e.g. BMW i4 Gran Coupe" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Battery Capacity (kWh)</label>
                    <input type="number" step="0.1" name="capacity" class="form-control" placeholder="83.9" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Connector Type</label>
                    <select name="connector" class="form-select" required>
                        <option value="CCS2">CCS2 (Combined Charging System)</option>
                        <option value="Type 2">Type 2 (AC Fast)</option>
                        <option value="CHAdeMO">CHAdeMO</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Max Charging Power (kW)</label>
                    <input type="number" name="max_power" class="form-control" placeholder="205" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-sm" onclick="closeModal('addEvModal')">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm">Save EV Profile</button>
            </div>
        </form>
    </div>
</div>

<!-- Quick Station Booking / Navigation Modal -->
<div class="modal-backdrop" id="bookStationModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 style="font-size: 1.2rem;">🔌 Reserve Charging Slot</h3>
            <button class="modal-close" onclick="closeModal('bookStationModal')">&times;</button>
        </div>
        <div class="modal-body">
            <p style="margin-bottom: 1rem; font-size: 0.9rem; color: var(--text-muted);">
                Locking in a 240kW CCS2 Port at <strong>AeroCity HyperCharge Superhub</strong>.
            </p>
            <div class="form-group">
                <label class="form-label">Target Arrival Time</label>
                <input type="time" class="form-control" value="17:30">
            </div>
            <div class="form-group">
                <label class="form-label">Estimated Charge Target %</label>
                <select class="form-select">
                    <option value="80">80% (Recommended for longevity)</option>
                    <option value="100">100% Full Range</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline btn-sm" onclick="closeModal('bookStationModal')">Close</button>
            <button type="button" class="btn btn-primary btn-sm" onclick="closeModal('bookStationModal'); showToast('Charging slot reserved successfully!', 'success');">Confirm Reservation</button>
        </div>
    </div>
</div>
