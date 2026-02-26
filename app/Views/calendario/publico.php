<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Laboratorios — TECNM Campus Teziutlán</title>
    <meta name="description" content="Consulta la disponibilidad de laboratorios académicos del TECNM Teziutlán en tiempo real">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --tecnm-green: #1a7a4c;
            --tecnm-green-light: #22996a;
            --tecnm-green-dark: #115c38;
            --tecnm-navy: #1b2838;
            --tecnm-guinda: #691b32;
            --ease: cubic-bezier(0.4, 0, 0.2, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: #0e1a28;
            color: #e2e8f0;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* ── Background ──────────────────── */
        .bg-layer { position: fixed; inset: 0; z-index: 0; background: linear-gradient(160deg, #0b1520 0%, #14202f 35%, #1b2838 70%, #1f3044 100%); }
        .bg-orb { position: fixed; border-radius: 50%; filter: blur(100px); opacity: 0.12; pointer-events: none; z-index: 0; }
        .bg-orb-1 { width: 600px; height: 600px; background: var(--tecnm-green); top: -200px; right: -150px; animation: orbFloat 14s ease-in-out infinite; }
        .bg-orb-2 { width: 450px; height: 450px; background: var(--tecnm-guinda); bottom: -150px; left: -120px; animation: orbFloat 18s ease-in-out infinite reverse; }
        .bg-orb-3 { width: 250px; height: 250px; background: var(--tecnm-green-light); top: 45%; left: 55%; animation: orbFloat 12s ease-in-out infinite 3s; }

        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(25px, -30px) scale(1.03); }
            66% { transform: translate(-18px, 22px) scale(0.97); }
        }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-4px); } }

        /* ── Top Guinda Bar (TECNM gov) ──── */
        .gov-bar {
            position: relative; z-index: 100;
            background: var(--tecnm-guinda);
            padding: 6px 24px;
            display: flex; justify-content: center; align-items: center;
            font-size: 0.7rem; font-weight: 600; color: rgba(255,255,255,0.85);
            letter-spacing: 0.3px;
        }
        .gov-bar i { margin-right: 6px; font-size: 0.75rem; }

        /* ── Header ──────────────────────── */
        .public-header {
            position: sticky; top: 0; z-index: 100;
            background: rgba(27, 40, 56, 0.92);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .header-inner {
            max-width: 1200px; margin: 0 auto;
            display: flex; justify-content: space-between; align-items: center;
            padding: 10px 24px;
        }
        .brand { display: flex; align-items: center; gap: 10px; color: #fff; text-decoration: none; }
        .brand-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--tecnm-green-dark), var(--tecnm-green));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.15rem; color: #fff;
            box-shadow: 0 4px 12px rgba(26,122,76,0.3);
        }
        .brand-text { font-size: 1.15rem; font-weight: 800; letter-spacing: -0.3px; }
        .brand-sub { display: block; font-size: 0.58rem; font-weight: 500; color: #8a9bb8; letter-spacing: 0.5px; text-transform: uppercase; }
        .login-link {
            display: flex; align-items: center; gap: 6px;
            color: #a0b0c5; text-decoration: none;
            font-size: 0.82rem; font-weight: 600;
            padding: 8px 18px; border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.08);
            transition: all 0.3s var(--ease);
        }
        .login-link:hover {
            color: #fff; border-color: var(--tecnm-green);
            background: rgba(26,122,76,0.12);
            box-shadow: 0 0 14px rgba(26,122,76,0.15);
        }

        /* ── Hero ────────────────────────── */
        .hero {
            position: relative; z-index: 1;
            max-width: 1200px; margin: 0 auto;
            padding: 40px 24px 0; text-align: center;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(26,122,76,0.12);
            border: 1px solid rgba(26,122,76,0.2);
            border-radius: 30px; padding: 6px 18px;
            font-size: 0.73rem; font-weight: 600;
            color: var(--tecnm-green-light); margin-bottom: 12px;
            animation: fadeInUp 0.5s var(--ease);
        }
        .hero h1 {
            font-size: clamp(1.6rem, 3.5vw, 2.3rem);
            font-weight: 900; color: #fff;
            letter-spacing: -0.8px; margin-bottom: 8px;
            animation: fadeInUp 0.6s var(--ease);
        }
        .hero h1 .gradient-text {
            background: linear-gradient(135deg, #4ec890, #7edcad, #45b377);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero .hero-subtitle {
            color: #8a9bb8; font-size: 0.92rem;
            max-width: 520px; margin: 0 auto 6px;
            animation: fadeInUp 0.7s var(--ease);
        }
        .hero .hero-inst {
            color: #556680; font-size: 0.76rem; font-weight: 500;
            margin-bottom: 24px;
            animation: fadeInUp 0.75s var(--ease);
        }

        /* ── Info Stats ──────────────────── */
        .info-stats {
            display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;
            margin-bottom: 24px; animation: fadeInUp 0.85s var(--ease);
        }
        .info-stat {
            display: flex; align-items: center; gap: 7px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 10px; padding: 8px 16px;
            transition: all 0.3s var(--ease);
        }
        .info-stat:hover { background: rgba(255,255,255,0.06); border-color: rgba(26,122,76,0.2); transform: translateY(-2px); }
        .info-stat i { color: var(--tecnm-green-light); font-size: 0.95rem; }
        .info-stat span { font-size: 0.8rem; color: #b0bdd0; font-weight: 500; }

        /* ── Calendar ────────────────────── */
        .calendar-section {
            position: relative; z-index: 1;
            max-width: 1200px; margin: 0 auto;
            padding: 0 24px 36px;
        }
        .calendar-card {
            background: rgba(255,255,255,0.97);
            border-radius: 20px; padding: 26px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
            color: #1e293b;
            animation: fadeInUp 0.9s var(--ease);
        }

        /* FullCalendar */
        .fc { font-family: 'Inter', sans-serif !important; }
        .fc .fc-toolbar { margin-bottom: 18px !important; }
        .fc .fc-toolbar-title { font-size: 1.12rem !important; font-weight: 800; color: var(--tecnm-navy); }
        .fc .fc-button-primary {
            background: linear-gradient(135deg, var(--tecnm-green-dark), var(--tecnm-green)) !important;
            border: none !important; border-radius: 10px !important;
            font-weight: 700 !important; font-size: 0.8rem !important;
            box-shadow: 0 2px 8px rgba(26,122,76,0.2) !important;
            transition: all 0.25s var(--ease) !important;
            padding: 7px 14px !important;
        }
        .fc .fc-button-primary:hover { transform: translateY(-1px) !important; box-shadow: 0 4px 12px rgba(26,122,76,0.3) !important; }
        .fc .fc-button-primary:not(:disabled).fc-button-active,
        .fc .fc-button-primary:not(:disabled):active { background: linear-gradient(135deg, #0d4a2b, var(--tecnm-green-dark)) !important; }

        .fc .fc-col-header-cell { background: #f5f8f6 !important; border-color: #eef2f0 !important; }
        .fc .fc-col-header-cell-cushion {
            font-weight: 700; font-size: 0.74rem;
            color: var(--tecnm-navy); text-transform: uppercase;
            letter-spacing: 0.8px; padding: 9px 4px !important;
        }
        .fc .fc-daygrid-day { transition: background 0.2s ease !important; }
        .fc .fc-daygrid-day:hover { background: rgba(26,122,76,0.03) !important; }
        .fc .fc-daygrid-day-number { font-weight: 700; color: #475569; padding: 8px 10px !important; font-size: 0.86rem; }
        .fc .fc-day-today { background: rgba(26,122,76,0.04) !important; }
        .fc .fc-day-today .fc-daygrid-day-number {
            background: var(--tecnm-green); color: #fff !important;
            border-radius: 50%; width: 30px; height: 30px;
            display: flex; align-items: center; justify-content: center;
            margin: 4px; font-size: 0.84rem;
            box-shadow: 0 2px 8px rgba(26,122,76,0.3);
        }
        .fc .fc-event {
            border-radius: 7px !important; padding: 3px 9px !important;
            font-size: 0.74rem !important; font-weight: 600 !important;
            border: none !important; box-shadow: 0 2px 5px rgba(0,0,0,0.08) !important;
            cursor: pointer !important; transition: all 0.2s var(--ease) !important;
            margin-bottom: 2px !important;
        }
        .fc .fc-event:hover { transform: translateY(-1px) scale(1.01) !important; box-shadow: 0 4px 10px rgba(0,0,0,0.12) !important; }
        .fc .fc-timegrid-slot { height: 42px !important; }
        .fc .fc-timegrid-slot-label-cushion { font-size: 0.74rem; font-weight: 600; color: #64748b; }
        .fc td, .fc th { border-color: #eef2f7 !important; }
        #calendar { min-height: 540px; }

        /* ── Legend ───────────────────────── */
        .calendar-legend {
            display: flex; gap: 16px; flex-wrap: wrap;
            justify-content: center; margin-top: 16px;
            padding-top: 14px; border-top: 1px solid #eef2f7;
        }
        .legend-item { display: flex; align-items: center; gap: 6px; font-size: 0.76rem; color: #64748b; font-weight: 500; }
        .legend-dot { width: 10px; height: 10px; border-radius: 4px; }

        /* ── Modal ────────────────────────── */
        .modal-content { border-radius: 18px; border: none; box-shadow: 0 25px 50px rgba(0,0,0,0.3); overflow: hidden; }
        .modal-header {
            background: linear-gradient(135deg, var(--tecnm-green-dark), var(--tecnm-green));
            color: #fff; border: none; padding: 16px 22px;
        }
        .modal-header .btn-close { filter: brightness(0) invert(1); }
        .modal-body { padding: 22px; }
        .detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f5f9; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { color: #64748b; font-weight: 600; font-size: 0.83rem; }
        .detail-value { color: #0f172a; font-weight: 500; font-size: 0.88rem; }

        /* ── Footer ───────────────────────── */
        .public-footer {
            position: relative; z-index: 1;
            text-align: center; padding: 20px;
            color: #3d4d65; font-size: 0.73rem;
            border-top: 1px solid rgba(255,255,255,0.03);
        }
    </style>
</head>
<body>
    <div class="bg-layer"></div>
    <div class="bg-orb bg-orb-1"></div>
    <div class="bg-orb bg-orb-2"></div>
    <div class="bg-orb bg-orb-3"></div>

    <!-- Gobierno guinda bar -->
    <div class="gov-bar">
        <i class="bi bi-mortarboard-fill"></i>
        <span>Tecnológico Nacional de México — Campus Teziutlán</span>
    </div>

    <!-- Header -->
    <header class="public-header">
        <div class="header-inner">
            <a href="/" class="brand">
                <div class="brand-icon"><i class="bi bi-mortarboard-fill"></i></div>
                <div>
                    <span class="brand-text">LabControl</span>
                    <span class="brand-sub">TECNM · Campus Teziutlán</span>
                </div>
            </a>
            <a href="/auth/login" class="login-link">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Iniciar Sesión</span>
            </a>
        </div>
    </header>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-badge">
            <i class="bi bi-broadcast"></i>
            <span>Disponibilidad en tiempo real</span>
        </div>
        <h1>Calendario de <span class="gradient-text">Laboratorios</span></h1>
        <p class="hero-subtitle">Consulta la disponibilidad y reservas aprobadas de los laboratorios académicos</p>
        <p class="hero-inst">Tecnológico Nacional de México — Campus Teziutlán, Puebla</p>

        <div class="info-stats">
            <div class="info-stat">
                <i class="bi bi-clock-fill"></i>
                <span>Lun — Vie · 7:00 AM — 4:00 PM</span>
            </div>
            <div class="info-stat">
                <i class="bi bi-check-circle-fill"></i>
                <span>Solo reservas aprobadas</span>
            </div>
            <div class="info-stat">
                <i class="bi bi-calendar-event-fill"></i>
                <span>Semestre actual</span>
            </div>
        </div>
    </section>

    <!-- Calendar -->
    <section class="calendar-section">
        <div class="calendar-card">
            <div id="calendar"></div>
            <div class="calendar-legend">
                <div class="legend-item"><span class="legend-dot" style="background:#1a7a4c"></span><span>Lab. Redes</span></div>
                <div class="legend-item"><span class="legend-dot" style="background:#2563eb"></span><span>Lab. Programación</span></div>
                <div class="legend-item"><span class="legend-dot" style="background:#f59e0b"></span><span>Lab. Electrónica</span></div>
                <div class="legend-item"><span class="legend-dot" style="background:#8b5cf6"></span><span>Otros</span></div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalTitle"><i class="bi bi-building-fill me-2"></i>Detalle de Reserva</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="eventModalBody"></div>
            </div>
        </div>
    </div>

    <footer class="public-footer">
        <p>&copy; <?= date('Y') ?> LabControl — Tecnológico Nacional de México, Campus Teziutlán, Puebla</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
            initialView: 'dayGridMonth',
            locale: 'es',
            headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek,timeGridDay' },
            buttonText: { today: 'Hoy', month: 'Mes', week: 'Semana', day: 'Día' },
            events: '/calendario/eventos',
            eventClick: function(info) {
                const p = info.event.extendedProps;
                const s = info.event.start, e = info.event.end;
                const fmt = {hour:'2-digit', minute:'2-digit'};
                const dfmt = {weekday:'long', year:'numeric', month:'long', day:'numeric'};
                document.getElementById('eventModalTitle').innerHTML = `<i class="bi bi-building-fill me-2"></i>${p.laboratorio || 'Reserva'}`;
                document.getElementById('eventModalBody').innerHTML = `
                    <div class="detail-row"><span class="detail-label"><i class="bi bi-building me-2"></i>Laboratorio</span><span class="detail-value">${p.laboratorio||'-'}</span></div>
                    <div class="detail-row"><span class="detail-label"><i class="bi bi-person me-2"></i>Docente</span><span class="detail-value">${p.usuario||'-'}</span></div>
                    <div class="detail-row"><span class="detail-label"><i class="bi bi-calendar me-2"></i>Fecha</span><span class="detail-value">${s?s.toLocaleDateString('es-MX',dfmt):''}</span></div>
                    <div class="detail-row"><span class="detail-label"><i class="bi bi-clock me-2"></i>Horario</span><span class="detail-value">${s?s.toLocaleTimeString('es-MX',fmt):''} — ${e?e.toLocaleTimeString('es-MX',fmt):''}</span></div>
                    ${p.carrera ? `<div class="detail-row"><span class="detail-label"><i class="bi bi-book me-2"></i>Carrera</span><span class="detail-value">${p.carrera}</span></div>` : ''}
                    ${p.semestre ? `<div class="detail-row"><span class="detail-label"><i class="bi bi-mortarboard me-2"></i>Semestre</span><span class="detail-value">${p.semestre}°</span></div>` : ''}
                    ${p.total_alumnos ? `<div class="detail-row"><span class="detail-label"><i class="bi bi-people me-2"></i>Alumnos</span><span class="detail-value">${p.total_alumnos}</span></div>` : ''}
                `;
                new bootstrap.Modal(document.getElementById('eventModal')).show();
            },
            height: 'auto', navLinks: true, editable: false, dayMaxEvents: 3, firstDay: 1,
            businessHours: { daysOfWeek: [1,2,3,4,5], startTime: '07:00', endTime: '16:00' },
            moreLinkText: 'más',
        });
        calendar.render();
    });
    </script>
</body>
</html>
