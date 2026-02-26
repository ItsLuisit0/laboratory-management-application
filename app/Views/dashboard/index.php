<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="dashboard-header mb-4">
    <h2 class="fw-bold">Panel de Administración</h2>
    <p class="text-muted">Bienvenido, <?= esc($user['nombre'] ?? '') ?> — <?= date('d/m/Y') ?></p>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-primary">
            <div class="stat-icon"><i class="bi bi-clock-fill"></i></div>
            <div class="stat-info">
                <span class="stat-value"><?= $total_pendientes ?? 0 ?></span>
                <span class="stat-label">Pendientes</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-success">
            <div class="stat-icon"><i class="bi bi-calendar-check-fill"></i></div>
            <div class="stat-info">
                <span class="stat-value"><?= $total_reservas ?? 0 ?></span>
                <span class="stat-label">Total Reservas</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-info">
            <div class="stat-icon"><i class="bi bi-building-fill"></i></div>
            <div class="stat-info">
                <span class="stat-value"><?= $total_laboratorios ?? 0 ?></span>
                <span class="stat-label">Laboratorios</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-warning">
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
            <div class="stat-info">
                <span class="stat-value"><?= $total_usuarios ?? 0 ?></span>
                <span class="stat-label">Usuarios</span>
            </div>
        </div>
    </div>
</div>

<!-- Today's Reservations -->
<div class="row g-4 mb-4">
    <div class="col-lg-7">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-calendar-day me-2"></i>Reservas de Hoy</h5>
                <a href="/calendario" class="btn btn-sm btn-outline-primary">Calendario</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead><tr><th>Laboratorio</th><th>Solicitante</th><th>Horario</th><th>Estado</th></tr></thead>
                        <tbody>
                            <?php foreach ($reservas_hoy ?? [] as $r): ?>
                            <tr>
                                <td><?= esc($r['laboratorio_nombre']) ?></td>
                                <td><?= esc($r['usuario_nombre']) ?></td>
                                <td><?= esc($r['hora_inicio']) ?> - <?= esc($r['hora_fin']) ?></td>
                                <td>
                                    <?php
                                        $bc = match($r['estado']) { 'APROBADA' => 'bg-success', 'RECHAZADA' => 'bg-danger', 'CANCELADA' => 'bg-secondary', default => 'bg-warning text-dark' };
                                    ?>
                                    <span class="badge <?= $bc ?>"><?= $r['estado'] ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($reservas_hoy)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-3">No hay reservas para hoy</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card shadow-sm h-100">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-lightning-charge-fill me-2"></i>Accesos Rápidos</h5></div>
            <div class="card-body d-flex flex-column gap-2">
                <a href="/usuarios" class="btn btn-outline-primary"><i class="bi bi-people-fill me-2"></i>Gestionar Usuarios</a>
                <a href="/laboratorios" class="btn btn-outline-primary"><i class="bi bi-building-fill me-2"></i>Gestionar Laboratorios</a>
                <a href="/reportes" class="btn btn-outline-primary"><i class="bi bi-file-earmark-pdf-fill me-2"></i>Generar Reporte</a>
                <a href="/reservas" class="btn btn-outline-primary"><i class="bi bi-calendar-check-fill me-2"></i>Ver Reservas</a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Actividad Reciente (últimos 7 días)</h5>
        <a href="/reservas" class="btn btn-sm btn-outline-primary">Ver todas</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>ID</th><th>Laboratorio</th><th>Solicitante</th><th>Fecha</th><th>Horario</th><th>Estado</th></tr></thead>
                <tbody>
                    <?php foreach (array_slice($reservas_recientes ?? [], 0, 10) as $r): ?>
                    <tr>
                        <td><strong>#<?= $r['id_reserva'] ?></strong></td>
                        <td><?= esc($r['laboratorio_nombre']) ?></td>
                        <td><?= esc($r['usuario_nombre']) ?></td>
                        <td><?= esc($r['fecha']) ?></td>
                        <td><?= esc($r['hora_inicio']) ?> - <?= esc($r['hora_fin']) ?></td>
                        <td>
                            <?php
                                $bc = match($r['estado']) { 'APROBADA' => 'bg-success', 'RECHAZADA' => 'bg-danger', 'CANCELADA' => 'bg-secondary', default => 'bg-warning text-dark' };
                            ?>
                            <span class="badge <?= $bc ?>"><?= $r['estado'] ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($reservas_recientes)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-3">Sin actividad reciente</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
