<?php $user = session()->get('user'); ?>
<nav class="top-navbar">
    <div class="navbar-left">
        <button class="btn btn-link sidebar-toggle-btn" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
    </div>
    <div class="navbar-right">
        <div class="navbar-user dropdown">
            <button class="btn dropdown-toggle user-dropdown" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle me-1"></i>
                <span class="d-none d-sm-inline"><?= esc($user['nombre'] ?? '') ?></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><span class="dropdown-item-text text-muted small">Rol: <?= esc($user['rol_nombre'] ?? '') ?></span></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="/auth/logout"><i class="bi bi-box-arrow-left me-2"></i>Cerrar Sesión</a></li>
            </ul>
        </div>
    </div>
</nav>
