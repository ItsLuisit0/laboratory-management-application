<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 fade-in-up">
    <div>
        <h2 class="fw-bold mb-1">
            <?php if (strtoupper($user['rol_nombre'] ?? '') === 'MAESTRO'): ?>
                Mis Reservas
            <?php else: ?>
                Reservas
            <?php endif; ?>
        </h2>
        <p class="text-muted mb-0" style="font-size:0.88rem"><?= count($reservas ?? []) ?> reserva<?= count($reservas ?? []) !== 1 ? 's' : '' ?></p>
    </div>
    <?php if (strtoupper($user['rol_nombre'] ?? '') === 'MAESTRO'): ?>
    <a href="/reservas/crear" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Nueva Solicitud
    </a>
    <?php endif; ?>
</div>

<?php if (!empty($reservas)): ?>
<div class="row g-3">
    <?php foreach ($reservas as $r): ?>
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body py-3">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <?php
                            $iconBg = match($r['estado']) {
                                'APROBADA'   => 'background:linear-gradient(135deg,#1a7a4c,#115c38)',
                                'COMPLETADA' => 'background:linear-gradient(135deg,#1b2838,#243347)',
                                'RECHAZADA'  => 'background:linear-gradient(135deg,#ef4444,#dc2626)',
                                'CANCELADA'  => 'background:linear-gradient(135deg,#6b7280,#4b5563)',
                                default      => 'background:linear-gradient(135deg,#f59e0b,#d97706)',
                            };
                        ?>
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                             style="width:48px;height:48px;<?= $iconBg ?>;color:#fff;font-size:1.2rem;">
                            <i class="bi bi-calendar-check-fill"></i>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <strong style="font-size:0.95rem"><?= esc($r['laboratorio_nombre']) ?></strong>
                            <?php
                                $bc = match($r['estado']) { 'APROBADA' => 'bg-success', 'COMPLETADA' => 'bg-dark', 'RECHAZADA' => 'bg-danger', 'CANCELADA' => 'bg-secondary', default => 'bg-warning text-dark' };
                            ?>
                            <span class="badge <?= $bc ?>" style="font-size:0.65rem"><?= $r['estado'] ?></span>
                        </div>
                        <div class="d-flex gap-3 text-muted" style="font-size:0.82rem">
                            <span><i class="bi bi-person-fill me-1"></i><?= esc($r['usuario_nombre']) ?></span>
                            <span><i class="bi bi-calendar-fill me-1"></i><?= esc($r['fecha']) ?></span>
                            <span><i class="bi bi-clock-fill me-1"></i><?= esc($r['hora_inicio']) ?> — <?= esc($r['hora_fin']) ?></span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <a href="/reservas/detalle/<?= $r['id_reserva'] ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye-fill me-1"></i> Ver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="card shadow-sm">
    <div class="card-body text-center py-5">
        <i class="bi bi-calendar-x display-3 text-muted d-block mb-3"></i>
        <h4 class="text-muted">No hay reservas</h4>
        <?php if (strtoupper($user['rol_nombre'] ?? '') === 'MAESTRO'): ?>
        <a href="/reservas/crear" class="btn btn-primary mt-2"><i class="bi bi-plus-lg me-1"></i> Solicitar Laboratorio</a>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
