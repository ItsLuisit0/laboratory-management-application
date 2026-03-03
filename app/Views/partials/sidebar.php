<?php
$user = session()->get('user');
$rolNombre = strtoupper($user['rol_nombre'] ?? '');
$currentPath = uri_string(); // e.g. "reservas", "reservas/crear", "reservas/detalle/5"

/**
 * Helper: returns 'active' only if the current path matches exactly,
 * or starts with the given path followed by '/' (for sub-pages like /detalle/5).
 * This prevents /reservas/crear from matching /reservas.
 */
function isActive(string $path, string $current): string {
    $path = trim($path, '/');
    $current = trim($current, '/');
    if ($current === $path) return 'active';
    if (str_starts_with($current, $path . '/')) return 'active';
    return '';
}
?>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <i class="bi bi-mortarboard-fill"></i>
            <span>
                LabControl
                <span class="brand-sub">TECNM · Teziutlán</span>
            </span>
        </div>
        <button class="sidebar-toggle d-md-none" id="sidebarClose">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="sidebar-user">
        <div class="user-avatar">
            <i class="bi bi-person-circle"></i>
        </div>
        <div class="user-info">
            <span class="user-name"><?= esc($user['nombre'] ?? '') ?></span>
            <span class="user-role badge-role"><?= esc($rolNombre) ?></span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-list">

            <?php // ── ADMIN: Dashboard + full management ── ?>
            <?php if ($rolNombre === 'ADMIN'): ?>
            <li class="nav-item">
                <a href="/dashboard" class="nav-link <?= isActive('dashboard', $currentPath) ?>">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-section">Administración</li>
            <li class="nav-item">
                <a href="/usuarios" class="nav-link <?= isActive('usuarios', $currentPath) ?>">
                    <i class="bi bi-people-fill"></i>
                    <span>Usuarios</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/laboratorios" class="nav-link <?= isActive('laboratorios', $currentPath) ?>">
                    <i class="bi bi-building-fill"></i>
                    <span>Laboratorios</span>
                </a>
            </li>
            <li class="nav-section">Reservas</li>
            <li class="nav-item">
                <a href="/reservas" class="nav-link <?= isActive('reservas', $currentPath) ?>">
                    <i class="bi bi-calendar-check-fill"></i>
                    <span>Todas las Reservas</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/practicas" class="nav-link <?= isActive('practicas', $currentPath) ?>">
                    <i class="bi bi-journal-text"></i>
                    <span>Prácticas</span>
                </a>
            </li>
            <li class="nav-section">Herramientas</li>
            <li class="nav-item">
                <a href="/calendario" class="nav-link <?= isActive('calendario', $currentPath) ?>">
                    <i class="bi bi-calendar3"></i>
                    <span>Calendario</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/reportes" class="nav-link <?= isActive('reportes', $currentPath) ?>">
                    <i class="bi bi-file-earmark-pdf-fill"></i>
                    <span>Reportes</span>
                </a>
            </li>
            <?php endif; ?>

            <?php // ── JEFE DE CARRERA: Approve/reject + view requests ── ?>
            <?php if ($rolNombre === 'JEFE'): ?>
            <li class="nav-section">Solicitudes</li>
            <li class="nav-item">
                <a href="/reservas/pendientes" class="nav-link <?= isActive('reservas/pendientes', $currentPath) ?>">
                    <i class="bi bi-clock-fill"></i>
                    <span>Pendientes</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/reservas" class="nav-link <?= $currentPath === 'reservas' || (str_starts_with($currentPath, 'reservas/') && !str_starts_with($currentPath, 'reservas/pendientes') && !str_starts_with($currentPath, 'reservas/crear')) ? 'active' : '' ?>">
                    <i class="bi bi-calendar-check-fill"></i>
                    <span>Historial de Reservas</span>
                </a>
            </li>

            <li class="nav-section">Vista</li>
            <li class="nav-item">
                <a href="/calendario" class="nav-link <?= isActive('calendario', $currentPath) ?>">
                    <i class="bi bi-calendar3"></i>
                    <span>Calendario</span>
                </a>
            </li>
            <?php endif; ?>

            <?php // ── MAESTRO: Request labs + view own reservations ── ?>
            <?php if ($rolNombre === 'MAESTRO'): ?>
            <li class="nav-section">Mis Reservas</li>
            <li class="nav-item">
                <a href="/reservas" class="nav-link <?= $currentPath === 'reservas' || (str_starts_with($currentPath, 'reservas/detalle') ) ? 'active' : '' ?>">
                    <i class="bi bi-calendar-check-fill"></i>
                    <span>Mis Reservas</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/reservas/crear" class="nav-link <?= isActive('reservas/crear', $currentPath) ?>">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>Solicitar Laboratorio</span>
                </a>
            </li>
            <li class="nav-section">Vista</li>
            <li class="nav-item">
                <a href="/calendario" class="nav-link <?= isActive('calendario', $currentPath) ?>">
                    <i class="bi bi-calendar3"></i>
                    <span>Calendario</span>
                </a>
            </li>
            <?php endif; ?>

        </ul>
    </nav>

    <div class="sidebar-footer">
        <a href="/auth/logout" class="btn btn-logout">
            <i class="bi bi-box-arrow-left"></i>
            <span>Cerrar Sesión</span>
        </a>
    </div>
</aside>
