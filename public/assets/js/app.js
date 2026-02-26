/**
 * LabControl — App JavaScript v3
 * TECNM Teziutlán · Premium interactions & toast notifications
 */
document.addEventListener('DOMContentLoaded', function () {

    // ── Sidebar Toggle (mobile) ─────────────────
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const closeBtn = document.getElementById('sidebarClose');

    toggleBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        sidebar?.classList.toggle('show');
    });
    closeBtn?.addEventListener('click', () => {
        sidebar?.classList.remove('show');
    });

    document.addEventListener('click', (e) => {
        if (sidebar?.classList.contains('show') &&
            !sidebar.contains(e.target) &&
            e.target !== toggleBtn) {
            sidebar.classList.remove('show');
        }
    });

    // ── Auto-dismiss alerts ─────────────────────
    document.querySelectorAll('.alert:not(.alert-permanent)').forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // ── Staggered card animation ────────────────
    document.querySelectorAll('.card, .stat-card').forEach((el, i) => {
        el.style.animationDelay = `${i * 0.05}s`;
    });

    // ── Active nav link highlighting ────────────
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-link').forEach(link => {
        const href = link.getAttribute('href');
        if (href && currentPath.startsWith(href) && href !== '/') {
            link.classList.add('active');
        }
    });

    // ── Number counter animation ────────────────
    document.querySelectorAll('.stat-value').forEach(el => {
        const target = parseInt(el.textContent);
        if (isNaN(target) || target === 0) return;
        el.textContent = '0';
        let current = 0;
        const increment = Math.max(1, Math.ceil(target / 30));
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) { current = target; clearInterval(timer); }
            el.textContent = current;
        }, 30);
    });

    // ── Delete confirmation (in-app dialog) ────
    document.querySelectorAll('.btn-delete-confirm').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const href = this.getAttribute('href');
            const msg = this.dataset.msg || '¿Estás seguro de que deseas eliminar este elemento?';
            LabToast.confirm(msg, function () {
                window.location.href = href;
            });
        });
    });

    // ── Tooltip initialization ──────────────────
    [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        .map(el => new bootstrap.Tooltip(el));

    // ── Confirm dialogs (in-app) ────────────────
    document.querySelectorAll('form[data-confirm]').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const msg = this.dataset.confirm;
            const f = this;
            LabToast.confirm(msg, function () { f.submit(); });
        });
    });
});

/**
 * ═══════════════════════════════════════════
 *  LabToast — In-App Toast Notification System
 * ═══════════════════════════════════════════
 */
const LabToast = (() => {
    let container = null;
    let confirmOverlay = null;

    function getContainer() {
        if (!container) {
            container = document.createElement('div');
            container.id = 'labtoast-container';
            Object.assign(container.style, {
                position: 'fixed', top: '20px', right: '20px', zIndex: '9999',
                display: 'flex', flexDirection: 'column', gap: '10px',
                maxWidth: '400px', width: '100%', pointerEvents: 'none'
            });
            document.body.appendChild(container);
        }
        return container;
    }

    const icons = {
        error: 'bi-exclamation-triangle-fill',
        warning: 'bi-exclamation-circle-fill',
        success: 'bi-check-circle-fill',
        info: 'bi-info-circle-fill'
    };
    const colors = {
        error: { bg: 'linear-gradient(135deg, #691b32, #8a2445)', border: '#691b32', icon: '#fca5a5' },
        warning: { bg: 'linear-gradient(135deg, #92400e, #b45309)', border: '#f59e0b', icon: '#fcd34d' },
        success: { bg: 'linear-gradient(135deg, #115c38, #1a7a4c)', border: '#1a7a4c', icon: '#6ee7b7' },
        info: { bg: 'linear-gradient(135deg, #1b2838, #243347)', border: '#2e6da4', icon: '#93c5fd' }
    };

    function show(message, type = 'info', duration = 4500) {
        const c = getContainer();
        const toast = document.createElement('div');
        const col = colors[type] || colors.info;
        const ic = icons[type] || icons.info;

        Object.assign(toast.style, {
            background: col.bg, color: '#fff',
            borderRadius: '14px', padding: '14px 18px',
            display: 'flex', alignItems: 'flex-start', gap: '12px',
            boxShadow: '0 10px 30px rgba(0,0,0,0.25), 0 0 0 1px ' + col.border,
            pointerEvents: 'auto', cursor: 'pointer',
            opacity: '0', transform: 'translateX(40px) scale(0.95)',
            transition: 'all 0.35s cubic-bezier(0.4, 0, 0.2, 1)',
            fontFamily: "'Inter', sans-serif", fontSize: '0.88rem',
            lineHeight: '1.5', position: 'relative', overflow: 'hidden'
        });

        // Progress bar
        const progress = document.createElement('div');
        Object.assign(progress.style, {
            position: 'absolute', bottom: '0', left: '0', height: '3px',
            background: 'rgba(255,255,255,0.35)', borderRadius: '0 0 14px 14px',
            width: '100%', transition: `width ${duration}ms linear`
        });

        toast.innerHTML = `
            <i class="bi ${ic}" style="font-size:1.2rem;color:${col.icon};margin-top:1px;flex-shrink:0"></i>
            <div style="flex:1">
                <div style="font-weight:700;font-size:0.75rem;text-transform:uppercase;letter-spacing:0.6px;opacity:0.8;margin-bottom:2px">${type === 'error' ? 'Error' : type === 'warning' ? 'Atención' : type === 'success' ? 'Éxito' : 'Información'}</div>
                <div>${message}</div>
            </div>
            <button style="background:none;border:none;color:rgba(255,255,255,0.6);font-size:1.1rem;cursor:pointer;padding:0;line-height:1" onclick="this.parentElement.style.opacity='0';this.parentElement.style.transform='translateX(40px)';setTimeout(()=>this.parentElement.remove(),300)">
                <i class="bi bi-x-lg"></i>
            </button>
        `;
        toast.appendChild(progress);

        toast.addEventListener('click', () => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(40px)';
            setTimeout(() => toast.remove(), 300);
        });

        c.appendChild(toast);

        requestAnimationFrame(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateX(0) scale(1)';
            requestAnimationFrame(() => { progress.style.width = '0'; });
        });

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(40px) scale(0.95)';
            setTimeout(() => toast.remove(), 400);
        }, duration);
    }

    function confirm(message, onConfirm, onCancel) {
        if (confirmOverlay) confirmOverlay.remove();

        confirmOverlay = document.createElement('div');
        Object.assign(confirmOverlay.style, {
            position: 'fixed', inset: '0', zIndex: '10000',
            background: 'rgba(0,0,0,0.5)', backdropFilter: 'blur(4px)',
            display: 'flex', alignItems: 'center', justifyContent: 'center',
            opacity: '0', transition: 'opacity 0.25s ease',
            fontFamily: "'Inter', sans-serif", padding: '20px'
        });

        const dialog = document.createElement('div');
        Object.assign(dialog.style, {
            background: '#fff', borderRadius: '20px', padding: '32px',
            maxWidth: '420px', width: '100%', textAlign: 'center',
            boxShadow: '0 25px 50px rgba(0,0,0,0.2)',
            transform: 'scale(0.9)', transition: 'transform 0.3s cubic-bezier(0.4, 0, 0.2, 1)'
        });

        dialog.innerHTML = `
            <div style="width:56px;height:56px;border-radius:16px;background:linear-gradient(135deg,rgba(245,158,11,0.12),rgba(251,191,36,0.08));display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                <i class="bi bi-exclamation-triangle-fill" style="font-size:1.5rem;color:#f59e0b"></i>
            </div>
            <h5 style="font-weight:800;color:#0f172a;margin-bottom:8px;font-size:1.1rem">¿Estás seguro?</h5>
            <p style="color:#64748b;font-size:0.88rem;margin-bottom:24px;line-height:1.6">${message}</p>
            <div style="display:flex;gap:10px;justify-content:center">
                <button id="labtoast-cancel" style="padding:10px 24px;border-radius:12px;border:2px solid #e2e8f0;background:#fff;color:#475569;font-weight:600;font-size:0.87rem;cursor:pointer;transition:all 0.2s ease">
                    Cancelar
                </button>
                <button id="labtoast-confirm" style="padding:10px 24px;border-radius:12px;border:none;background:linear-gradient(135deg,#691b32,#8a2445);color:#fff;font-weight:600;font-size:0.87rem;cursor:pointer;box-shadow:0 4px 12px rgba(105,27,50,0.25);transition:all 0.2s ease">
                    Confirmar
                </button>
            </div>
        `;

        confirmOverlay.appendChild(dialog);
        document.body.appendChild(confirmOverlay);

        requestAnimationFrame(() => {
            confirmOverlay.style.opacity = '1';
            dialog.style.transform = 'scale(1)';
        });

        function close() {
            confirmOverlay.style.opacity = '0';
            dialog.style.transform = 'scale(0.9)';
            setTimeout(() => { confirmOverlay.remove(); confirmOverlay = null; }, 300);
        }

        dialog.querySelector('#labtoast-cancel').addEventListener('click', () => {
            close();
            if (onCancel) onCancel();
        });
        dialog.querySelector('#labtoast-confirm').addEventListener('click', () => {
            close();
            if (onConfirm) onConfirm();
        });
        confirmOverlay.addEventListener('click', (e) => {
            if (e.target === confirmOverlay) { close(); if (onCancel) onCancel(); }
        });
    }

    return { show, success: (m, d) => show(m, 'success', d), error: (m, d) => show(m, 'error', d), warning: (m, d) => show(m, 'warning', d), info: (m, d) => show(m, 'info', d), confirm };
})();
