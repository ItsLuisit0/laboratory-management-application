<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Laboratorios — TECNM Campus Teziutlán</title>
    <meta name="description" content="Consulta la disponibilidad de laboratorios académicos del TECNM Teziutlán en tiempo real">
    <!-- Preconnect -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ── Variables ─────────────────────── */
        :root {
            --gov-guinda: #6b1127;
            --gov-guinda-dark: #4e0d1e;
            --nav-blue: #1c3664;
            --nav-blue-light: #254e8f;
            --tecnm-green: #1a803c;
            --tecnm-green-light: #22a050;
            --tecnm-green-pale: #e8f5ee;
            --white: #ffffff;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-400: #94a3b8;
            --gray-600: #475569;
            --gray-800: #1e293b;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.10);
            --shadow-lg: 0 10px 40px rgba(0,0,0,0.15);
            --radius: 10px;
            --transition: 0.22s ease;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', Arial, sans-serif;
            background: var(--gray-100);
            color: var(--gray-800);
            font-size: 0.92rem;
            min-height: 100vh;
        }


        /* ── Logos header ─────────────────── */
        .logos-header {
            background: var(--white);
            padding: 14px 24px;
            display: flex;
            align-items: center;
            gap: 18px;
            box-shadow: 0 2px 8px rgba(28,54,100,0.07);
            position: relative;
            z-index: 10;
        }
        .logo-block {
            display: flex;
            align-items: center;
            gap: 9px;
        }
        .logo-icon-sep {
            width: 34px; height: 34px;
            background: radial-gradient(circle, #9b2235 0%, #6b1127 100%);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(107,17,39,0.3);
        }
        .logo-icon-tecnm {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--nav-blue) 0%, #254e8f 100%);
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.6rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: 0.5px;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(28,54,100,0.3);
        }
        .logo-icon-tec {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--tecnm-green) 0%, #0d6e31 100%);
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(26,128,60,0.3);
        }
        .logo-icon-tec svg { width: 28px; }
        .logo-text {
            font-size: 0.67rem;
            color: var(--gray-600);
            line-height: 1.3;
        }
        .logo-text strong { display: block; font-size: 0.75rem; color: var(--gray-800); }
        .logo-divider {
            width: 1px; height: 46px;
            background: linear-gradient(to bottom, transparent, var(--gray-200), transparent);
        }
        .header-actions {
            margin-left: auto;
            display: flex;
            gap: 10px;
        }
        .header-icon-btn {
            width: 36px; height: 36px;
            border: 1.5px solid var(--gray-200);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: var(--gray-600);
            text-decoration: none;
            font-size: 1rem;
            transition: all var(--transition);
            background: var(--white);
        }
        .header-icon-btn:hover {
            border-color: var(--nav-blue);
            color: var(--nav-blue);
            background: rgba(28,54,100,0.04);
        }

        /* ── Navigation bar ───────────────── */
        .main-nav {
            background: var(--nav-blue);
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 3px 12px rgba(28,54,100,0.35);
            display: flex;
            align-items: center;
        }
        .nav-brand {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 11px 20px 11px 0;
            border-right: 1px solid rgba(255,255,255,0.12);
            margin-right: 6px;
            text-decoration: none;
            transition: opacity var(--transition);
        }
        .nav-brand:hover { opacity: 0.88; }
        .nav-brand-icon {
            width: 30px; height: 30px;
            background: var(--tecnm-green);
            border-radius: 5px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800;
            font-size: 0.88rem;
            color: #fff;
            flex-shrink: 0;
        }
        .nav-brand span {
            font-size: 0.82rem;
            font-weight: 700;
            color: rgba(255,255,255,0.95);
            letter-spacing: 0.1px;
        }

        .nav-login {
            margin-left: auto;
            padding: 10px 0;
        }
        .btn-login {
            background: var(--tecnm-green);
            color: #fff !important;
            border-radius: 6px;
            padding: 8px 18px;
            font-size: 0.76rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            transition: all var(--transition);
            border: none;
            box-shadow: 0 2px 8px rgba(26,128,60,0.4);
        }
        .btn-login:hover {
            background: var(--tecnm-green-light);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(26,128,60,0.45);
        }

        /* ── Page hero ────────────────────── */
        .page-hero {
            background:
                linear-gradient(130deg, rgba(13,33,71,0.82) 0%, rgba(28,54,100,0.78) 45%, rgba(26,92,48,0.80) 100%),
                url('/assets/images/SALONES.png') center/cover no-repeat;
            color: #fff;
            padding: 90px 32px 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .page-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(26,128,60,0.18) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(255,255,255,0.05) 0%, transparent 50%);
        }
        /* Decorative grid */
        .page-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        .hero-content {
            position: relative;
            z-index: 1;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(26,128,60,0.25);
            border: 1px solid rgba(26,128,60,0.5);
            border-radius: 20px;
            padding: 5px 16px;
            font-size: 0.73rem;
            font-weight: 600;
            color: #a8f0c0;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 18px;
        }
        .hero-badge .dot {
            width: 7px; height: 7px;
            background: #4ade80;
            border-radius: 50%;
            animation: pulse-dot 2s infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.75); }
        }
        .page-hero h1 {
            font-size: 2.1rem;
            font-weight: 800;
            margin-bottom: 10px;
            line-height: 1.15;
            letter-spacing: -0.5px;
        }
        .page-hero h1 .highlight {
            color: #86efac;
        }
        .page-hero .subtitle {
            font-size: 0.92rem;
            color: rgba(255,255,255,0.72);
            margin-bottom: 28px;
            max-width: 560px;
            margin-left: auto;
            margin-right: auto;
        }
        .hero-chips {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .hero-chip {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 24px;
            padding: 6px 16px;
            font-size: 0.76rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            backdrop-filter: blur(4px);
            transition: all var(--transition);
        }
        .hero-chip:hover {
            background: rgba(255,255,255,0.18);
            border-color: rgba(255,255,255,0.35);
        }
        .hero-chip i { color: #86efac; }

        /* ── Stats row ────────────────────── */
        .stats-band {
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            padding: 0 32px;
        }
        .stats-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            divide: 1px;
        }
        .stat-cell {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 24px;
            border-right: 1px solid var(--gray-200);
            transition: background var(--transition);
        }
        .stat-cell:first-child { padding-left: 0; }
        .stat-cell:last-child { border-right: none; }
        .stat-cell:hover { background: var(--gray-50); }
        .stat-icon {
            width: 40px; height: 40px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }
        .stat-icon.green { background: var(--tecnm-green-pale); color: var(--tecnm-green); }
        .stat-icon.blue { background: rgba(28,54,100,0.08); color: var(--nav-blue); }
        .stat-icon.amber { background: #fef3c7; color: #b45309; }
        .stat-icon.purple { background: #f3e8ff; color: #7c3aed; }
        .stat-label { font-size: 0.7rem; color: var(--gray-400); font-weight: 500; margin-bottom: 2px; text-transform: uppercase; letter-spacing: 0.4px; }
        .stat-value { font-size: 0.88rem; font-weight: 700; color: var(--gray-800); }

        /* ── Main content ─────────────────── */
        .main-content {
            max-width: 1200px;
            margin: 28px auto;
            padding: 0 24px 60px;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }
        .section-title {
            font-size: 0.98rem;
            font-weight: 700;
            color: var(--nav-blue);
            display: flex;
            align-items: center;
            gap: 9px;
        }
        .section-title .title-bar {
            width: 4px; height: 20px;
            background: linear-gradient(to bottom, var(--tecnm-green), var(--nav-blue));
            border-radius: 2px;
        }
        .section-badge {
            background: var(--tecnm-green-pale);
            color: var(--tecnm-green);
            font-size: 0.7rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 12px;
            letter-spacing: 0.3px;
        }

        /* ── Calendar card ────────────────── */
        .calendar-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--gray-200);
            position: relative;
            overflow: hidden;
        }
        .calendar-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(to right, var(--nav-blue), var(--tecnm-green));
        }

        /* FullCalendar overrides */
        .fc { font-family: 'Inter', Arial, sans-serif !important; }
        .fc .fc-toolbar-title { font-size: 1.05rem !important; font-weight: 700 !important; color: var(--nav-blue) !important; }
        .fc .fc-toolbar { margin-bottom: 18px !important; gap: 8px; flex-wrap: wrap; }
        .fc .fc-button-primary {
            background: var(--nav-blue) !important;
            border: none !important;
            border-radius: 6px !important;
            font-weight: 600 !important;
            font-size: 0.76rem !important;
            padding: 6px 14px !important;
            transition: all var(--transition) !important;
            box-shadow: 0 2px 6px rgba(28,54,100,0.25) !important;
        }
        .fc .fc-button-primary:hover { background: var(--nav-blue-light) !important; transform: translateY(-1px); }
        .fc .fc-button-primary:not(:disabled).fc-button-active,
        .fc .fc-button-primary:not(:disabled):active {
            background: var(--tecnm-green) !important;
            box-shadow: 0 2px 6px rgba(26,128,60,0.35) !important;
        }
        .fc .fc-button-group { gap: 4px; }
        .fc .fc-button-group > .fc-button { margin-left: 0 !important; }
        .fc .fc-col-header-cell {
            background: linear-gradient(135deg, var(--nav-blue) 0%, #254e8f 100%) !important;
            border: none !important;
        }
        .fc .fc-col-header-cell-cushion {
            font-weight: 700; font-size: 0.72rem;
            color: #fff !important; text-transform: uppercase;
            letter-spacing: 0.8px; padding: 10px 4px !important;
            text-decoration: none !important;
        }
        .fc .fc-scrollgrid { border-radius: 8px; overflow: hidden; border-color: var(--gray-200) !important; }
        .fc .fc-daygrid-day-number {
            font-weight: 600; color: var(--gray-600);
            padding: 7px 9px !important; font-size: 0.82rem;
            text-decoration: none !important;
        }
        .fc .fc-day-today {
            background: rgba(26,128,60,0.04) !important;
        }
        .fc .fc-day-today .fc-daygrid-day-number {
            background: var(--tecnm-green); color: #fff !important;
            border-radius: 50%; width: 28px; height: 28px;
            display: flex; align-items: center; justify-content: center;
            margin: 5px; font-size: 0.8rem; padding: 0 !important;
        }
        .fc .fc-event {
            border-radius: 5px !important; padding: 2px 8px !important;
            font-size: 0.72rem !important; font-weight: 600 !important;
            border: none !important; cursor: pointer !important;
            margin-bottom: 2px !important;
            transition: filter var(--transition) !important;
        }
        .fc .fc-event:hover { filter: brightness(1.1); }
        .fc td, .fc th { border-color: var(--gray-200) !important; }
        .fc .fc-daygrid-day:hover { background: rgba(28,54,100,0.025) !important; }
        .fc .fc-daygrid-more-link {
            color: var(--nav-blue) !important; font-weight: 600 !important;
            font-size: 0.7rem !important;
        }
        #calendar { min-height: 540px; }

        /* ── Legend ───────────────────────── */
        .calendar-legend {
            display: flex; gap: 8px; flex-wrap: wrap;
            margin-top: 18px; padding-top: 16px;
            border-top: 1px solid var(--gray-200);
        }
        .legend-item {
            display: inline-flex; align-items: center; gap: 7px;
            font-size: 0.73rem; color: var(--gray-600);
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: 20px;
            padding: 5px 12px;
            font-weight: 500;
        }
        .legend-dot { width: 9px; height: 9px; border-radius: 3px; flex-shrink: 0; }

        /* ── Modal ────────────────────────── */
        .modal-content {
            border-radius: var(--radius);
            border: none;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }
        .modal-header {
            background: linear-gradient(135deg, var(--nav-blue) 0%, #254e8f 100%);
            color: #fff; border: none; padding: 18px 22px;
        }
        .modal-header .modal-title { font-size: 0.95rem; font-weight: 700; }
        .modal-header .btn-close { filter: brightness(0) invert(1); opacity: 0.75; }
        .modal-body { padding: 20px 22px; }
        .detail-row {
            display: flex; justify-content: space-between; align-items: flex-start;
            padding: 10px 0; border-bottom: 1px solid var(--gray-100); gap: 12px;
        }
        .detail-row:last-child { border-bottom: none; padding-bottom: 0; }
        .detail-label {
            color: var(--gray-400); font-weight: 600; font-size: 0.78rem;
            display: flex; align-items: center; gap: 7px;
            min-width: 110px;
        }
        .detail-label i { color: var(--tecnm-green); }
        .detail-value { color: var(--gray-800); font-weight: 600; font-size: 0.85rem; text-align: right; }
        .modal-footer {
            background: var(--gray-50);
            border-top: 1px solid var(--gray-200);
            padding: 12px 22px;
            font-size: 0.73rem;
            color: var(--gray-400);
        }

        /* ── Footer ───────────────────────── */
        .public-footer {
            background: var(--nav-blue);
            color: rgba(255,255,255,0.55);
            text-align: center;
            padding: 0;
        }
        .footer-top {
            background: linear-gradient(to right, #0d2147, var(--nav-blue), #0d2147);
            padding: 32px 32px 24px;
            display: flex;
            justify-content: center;
            gap: 48px;
            flex-wrap: wrap;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .footer-col-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: rgba(255,255,255,0.85);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }
        .footer-col-title span {
            display: inline-block;
            width: 20px; height: 3px;
            background: var(--tecnm-green);
            border-radius: 2px;
            vertical-align: middle;
            margin-right: 6px;
        }
        .footer-link {
            display: block;
            color: rgba(255,255,255,0.55);
            text-decoration: none;
            font-size: 0.76rem;
            padding: 3px 0;
            transition: color var(--transition);
        }
        .footer-link:hover { color: rgba(255,255,255,0.9); }
        .footer-bottom {
            padding: 14px 28px;
            font-size: 0.73rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }
        .footer-bottom a { color: rgba(255,255,255,0.65); text-decoration: none; }
        .footer-bottom a:hover { color: #fff; }
        .footer-brand {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .footer-tec-badge {
            width: 28px; height: 28px;
            background: var(--tecnm-green);
            border-radius: 5px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 0.72rem; color: #fff;
        }

        /* ── Responsive ───────────────────── */
        @media (max-width: 1024px) {
            .stats-inner { flex-wrap: wrap; }
            .stat-cell {
                flex: 0 0 50%;
                border-right: none;
                border-bottom: 1px solid var(--gray-200);
            }
        }
        @media (max-width: 768px) {
            .logos-header { padding: 10px 16px; gap: 14px; }
            .logo-text { display: none; }
            .main-nav { padding: 0 12px; }
            .nav-links { overflow-x: auto; }
            .nav-links > li > a { padding: 12px 10px; font-size: 0.68rem; }
            .page-hero { padding: 36px 20px 32px; }
            .page-hero h1 { font-size: 1.5rem; }
            .main-content { padding: 0 12px 40px; }
            .stats-band { padding: 0 12px; }
            .stat-cell { flex: 0 0 100%; padding: 12px 0; }
            .stat-cell:first-child { padding-left: 0; }
            .footer-top { gap: 28px; padding: 24px 20px 20px; }
        }
        @media (max-width: 480px) {
            .nav-links { display: none; }
            .page-hero h1 { font-size: 1.3rem; }
        }
    </style>
</head>
<body>


    <!-- ── Logos header ───────────────────── -->
    <div class="logos-header">
        <!-- SEP -->
        <div class="logo-block">
            <img src="/assets/images/EducacionLOGO.png" alt="Educación SEP" style="height:60px; display:block;">
        </div>
        <div class="logo-divider"></div>
        <!-- TECNM -->
        <div class="logo-block">
            <img src="/assets/images/TECNACIONALMEXICO.png" alt="Tecnológico Nacional de México" style="height:60px; display:block;">
        </div>
        <div class="logo-divider"></div>
        <!-- TEC Teziutlan -->
        <div class="logo-block">
            <img src="/assets/images/TEC_Teziutlan.png" alt="TEC Campus Teziutlán" style="height:60px; display:block;">
        </div>
        <!-- Header icons -->
        <div class="header-actions">
            <a href="#" class="header-icon-btn" title="Correo institucional"><i class="bi bi-envelope-fill"></i></a>
            <a href="#" class="header-icon-btn" title="Calendario"><i class="bi bi-calendar3"></i></a>
        </div>
    </div>

    <!-- ── Navigation bar ─────────────────── -->
    <nav class="main-nav">
            <a href="/calendario" class="nav-brand">
                <img src="/assets/images/TEC_LOGO_BLANCO.png" alt="TEC de Teziutlán" style="height:32px; display:block;">
            </a>

            <div class="nav-login">
                <a href="/auth/login" class="btn-login">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Iniciar Sesión
                </a>
        </div>
    </nav>

    <!-- ── Page hero ───────────────────────── -->




    <!-- ── Main content ────────────────────── -->
    <div class="main-content">
        <div class="section-header">
            <div class="section-title">
                <span class="title-bar"></span>
                Reservas de Laboratorios — Vista Mensual
            </div>
            <span class="section-badge"><i class="bi bi-calendar3 me-1"></i>Tiempo real</span>
        </div>

        <!-- Calendar card -->
        <div class="calendar-card">
            <div id="calendar"></div>
            <div class="calendar-legend">
                <div class="legend-item"><span class="legend-dot" style="background:#1a803c"></span>Lab. Redes</div>
                <div class="legend-item"><span class="legend-dot" style="background:#1c3664"></span>Lab. Programación</div>
                <div class="legend-item"><span class="legend-dot" style="background:#b45309"></span>Lab. Electrónica</div>
                <div class="legend-item"><span class="legend-dot" style="background:#7c3aed"></span>Otros</div>
            </div>
        </div>
    </div>

    <!-- ── Event Modal ─────────────────────── -->
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalTitle">
                        <i class="bi bi-building-fill me-2"></i>Detalle de Reserva
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="eventModalBody"></div>
                <div class="modal-footer">
                    <i class="bi bi-info-circle me-1"></i>
                    Información oficial del sistema LabControl · TECNM Campus Teziutlán
                </div>
            </div>
        </div>
    </div>

    <!-- ── Footer ─────────────────────────── -->
    <footer class="public-footer">
        <div class="footer-top">
            <div>
                <div class="footer-col-title"><span></span>Institución</div>
                <a href="#" class="footer-link">Acerca del Campus</a>
                <a href="#" class="footer-link">Historia</a>
                <a href="#" class="footer-link">Organigrama</a>
                <a href="#" class="footer-link">Instalaciones</a>
            </div>
            <div>
                <div class="footer-col-title"><span></span>Servicios</div>
                <a href="#" class="footer-link">Plataforma Moodle</a>
                <a href="#" class="footer-link">Servicios Estudiantiles</a>
                <a href="#" class="footer-link">Biblioteca</a>
                <a href="/auth/login" class="footer-link">Acceso Administrativo</a>
            </div>
            <div>
                <div class="footer-col-title"><span></span>Contacto</div>
                <a href="#" class="footer-link"><i class="bi bi-geo-alt me-1"></i>Teziutlán, Puebla, México</a>
                <a href="#" class="footer-link"><i class="bi bi-envelope me-1"></i>Correo institucional</a>
                <a href="#" class="footer-link"><i class="bi bi-telephone me-1"></i>Directorio</a>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="footer-brand">
                <div class="footer-tec-badge">T</div>
                <span>© <?= date('Y') ?> LabControl — Tecnológico Nacional de México, Campus Teziutlán, Puebla</span>
            </div>
            <div>
                <a href="/auth/login">Acceso Administrativo</a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
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

                document.getElementById('eventModalTitle').innerHTML =
                    `<i class="bi bi-building-fill me-2"></i>${p.laboratorio || 'Detalle de Reserva'}`;

                document.getElementById('eventModalBody').innerHTML = `
                    <div class="detail-row">
                        <span class="detail-label"><i class="bi bi-building"></i>Laboratorio</span>
                        <span class="detail-value">${p.laboratorio||'-'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label"><i class="bi bi-person-fill"></i>Docente</span>
                        <span class="detail-value">${p.usuario||'-'}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label"><i class="bi bi-calendar-event"></i>Fecha</span>
                        <span class="detail-value">${s ? s.toLocaleDateString('es-MX', dfmt) : ''}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label"><i class="bi bi-clock"></i>Horario</span>
                        <span class="detail-value">${s ? s.toLocaleTimeString('es-MX', fmt) : ''} — ${e ? e.toLocaleTimeString('es-MX', fmt) : ''}</span>
                    </div>
                    ${p.carrera ? `<div class="detail-row"><span class="detail-label"><i class="bi bi-book"></i>Carrera</span><span class="detail-value">${p.carrera}</span></div>` : ''}
                    ${p.semestre ? `<div class="detail-row"><span class="detail-label"><i class="bi bi-mortarboard"></i>Semestre</span><span class="detail-value">${p.semestre}°</span></div>` : ''}
                    ${p.total_alumnos ? `<div class="detail-row"><span class="detail-label"><i class="bi bi-people"></i>Alumnos</span><span class="detail-value">${p.total_alumnos}</span></div>` : ''}
                `;
                new bootstrap.Modal(document.getElementById('eventModal')).show();
            },
            height: 'auto',
            navLinks: true,
            editable: false,
            dayMaxEvents: 3,
            firstDay: 1,
            businessHours: { daysOfWeek: [1,2,3,4,5,6], startTime: '07:00', endTime: '16:00' },
            moreLinkText: 'más',
        });
        calendar.render();
    });
    </script>
</body>
</html>
