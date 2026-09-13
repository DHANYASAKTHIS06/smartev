<?php
/**
 * Toast and Alert Notifications Renderer
 */
$flash = get_flash_message();
if ($flash):
?>
<div class="toast-container">
    <div class="toast toast-<?= htmlspecialchars($flash['type']) ?>">
        <span>⚡</span>
        <div style="flex:1;">
            <p style="margin:0; font-size:0.9rem; font-weight:600;"><?= htmlspecialchars($flash['message']) ?></p>
        </div>
        <button onclick="this.parentElement.remove()" style="background:none;border:none;color:#94a3b8;cursor:pointer;font-size:1.1rem;">&times;</button>
    </div>
</div>
<?php endif; ?>
