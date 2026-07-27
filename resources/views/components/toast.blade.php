@if(session('success') || session('error') || session('warning') || session('info'))
<div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; max-width: 360px;">
    @if(session('success'))
    <div class="toast toast-success" style="display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px; background: var(--bg-card); border: 1px solid var(--border-color); border-left: 4px solid #22c55e; border-radius: 10px; box-shadow: var(--shadow-lg); animation: slideInRight 0.3s ease;">
        <div style="width: 28px; height: 28px; min-width: 28px; background: rgba(34, 197, 94, 0.12); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-check" style="color: #22c55e; font-size: 0.8rem;"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-primary); margin-bottom: 2px;">Success</div>
            <div style="font-size: 0.8rem; color: var(--text-secondary); line-height: 1.4;">{{ session('success') }}</div>
        </div>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 4px; font-size: 0.9rem; line-height: 1;">&times;</button>
    </div>
    @endif

    @if(session('error'))
    <div class="toast toast-error" style="display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px; background: var(--bg-card); border: 1px solid var(--border-color); border-left: 4px solid #ef4444; border-radius: 10px; box-shadow: var(--shadow-lg); animation: slideInRight 0.3s ease;">
        <div style="width: 28px; height: 28px; min-width: 28px; background: rgba(239, 68, 68, 0.12); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-xmark" style="color: #ef4444; font-size: 0.8rem;"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-primary); margin-bottom: 2px;">Error</div>
            <div style="font-size: 0.8rem; color: var(--text-secondary); line-height: 1.4;">{{ session('error') }}</div>
        </div>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 4px; font-size: 0.9rem; line-height: 1;">&times;</button>
    </div>
    @endif

    @if(session('warning'))
    <div class="toast toast-warning" style="display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px; background: var(--bg-card); border: 1px solid var(--border-color); border-left: 4px solid #f59e0b; border-radius: 10px; box-shadow: var(--shadow-lg); animation: slideInRight 0.3s ease;">
        <div style="width: 28px; height: 28px; min-width: 28px; background: rgba(245, 158, 11, 0.12); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-exclamation" style="color: #f59e0b; font-size: 0.8rem;"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-primary); margin-bottom: 2px;">Warning</div>
            <div style="font-size: 0.8rem; color: var(--text-secondary); line-height: 1.4;">{{ session('warning') }}</div>
        </div>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 4px; font-size: 0.9rem; line-height: 1;">&times;</button>
    </div>
    @endif

    @if(session('info'))
    <div class="toast toast-info" style="display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px; background: var(--bg-card); border: 1px solid var(--border-color); border-left: 4px solid #3b82f6; border-radius: 10px; box-shadow: var(--shadow-lg); animation: slideInRight 0.3s ease;">
        <div style="width: 28px; height: 28px; min-width: 28px; background: rgba(59, 130, 246, 0.12); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-info" style="color: #3b82f6; font-size: 0.8rem;"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-primary); margin-bottom: 2px;">Info</div>
            <div style="font-size: 0.8rem; color: var(--text-secondary); line-height: 1.4;">{{ session('info') }}</div>
        </div>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 4px; font-size: 0.9rem; line-height: 1;">&times;</button>
    </div>
    @endif
</div>

<script>
(function() {
    var container = document.getElementById('toast-container');
    if (container) {
        setTimeout(function() {
            container.style.opacity = '0';
            container.style.transition = 'opacity 0.3s ease';
            setTimeout(function() { container.remove(); }, 300);
        }, 5000);
    }
})();
</script>

<style>
@keyframes slideInRight {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}
</style>
@endif
