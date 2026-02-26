<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Solicitudes Pendientes</h2>
    <span class="badge bg-warning text-dark fs-6"><?= count($reservas ?? []) ?> pendiente<?= count($reservas ?? []) !== 1 ? 's' : '' ?></span>
</div>

<?php if (!empty($reservas)): ?>
    <?php foreach ($reservas as $r): ?>
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <strong class="fs-5"><i class="bi bi-building-fill me-2 text-primary"></i><?= esc($r['laboratorio_nombre']) ?></strong>
                <span class="badge bg-warning text-dark ms-2">Pendiente</span>
            </div>
            <small class="text-muted">Solicitud #<?= esc($r['id_reserva']) ?></small>
        </div>
        <div class="card-body">
            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-fill text-primary me-2 fs-5"></i>
                        <div>
                            <small class="text-muted d-block">Solicitante</small>
                            <strong><?= esc($r['usuario_nombre']) ?></strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar-fill text-info me-2 fs-5"></i>
                        <div>
                            <small class="text-muted d-block">Fecha</small>
                            <strong><?= esc($r['fecha']) ?></strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-clock-fill text-success me-2 fs-5"></i>
                        <div>
                            <small class="text-muted d-block">Horario</small>
                            <strong><?= esc($r['hora_inicio']) ?> — <?= esc($r['hora_fin']) ?></strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar-event-fill text-secondary me-2 fs-5"></i>
                        <div>
                            <small class="text-muted d-block">Solicitado</small>
                            <strong><?= esc($r['fecha_creacion'] ?? 'N/A') ?></strong>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($r['contenido'])): ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded border-start border-4 border-primary">
                        <h6 class="fw-bold mb-2"><i class="bi bi-journal-text me-1"></i>Contenido de la Práctica</h6>
                        <p class="mb-0"><?= nl2br(esc($r['contenido'])) ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded border-start border-4 border-info">
                        <h6 class="fw-bold mb-2"><i class="bi bi-tools me-1"></i>Requerimientos / Materiales</h6>
                        <p class="mb-0"><?= !empty($r['requerimientos']) ? nl2br(esc($r['requerimientos'])) : '<span class="text-muted">Sin requerimientos especificados</span>' ?></p>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="alert alert-light border mb-0">
                <i class="bi bi-info-circle me-1"></i> El solicitante no proporcionó información de la práctica.
            </div>
            <?php endif; ?>
        </div>
        <div class="card-footer d-flex justify-content-end gap-2">
            <form action="/reservas/aprobar/<?= $r['id_reserva'] ?>" method="post" data-confirm="¿Aprobar esta solicitud de reserva? El docente será notificado.">
                <button class="btn btn-success" type="submit">
                    <i class="bi bi-check-lg me-1"></i> Aprobar
                </button>
            </form>
            <form action="/reservas/rechazar/<?= $r['id_reserva'] ?>" method="post" data-confirm="¿Rechazar esta solicitud de reserva? El docente será notificado.">
                <button class="btn btn-danger" type="submit">
                    <i class="bi bi-x-lg me-1"></i> Rechazar
                </button>
            </form>
        </div>
    </div>
    <?php endforeach; ?>

<?php else: ?>
<div class="card shadow-sm">
    <div class="card-body text-center py-5">
        <i class="bi bi-check-circle display-3 text-success d-block mb-3"></i>
        <h4 class="text-muted">No hay solicitudes pendientes</h4>
        <p class="text-muted">Todas las solicitudes han sido procesadas.</p>
        <a href="/reservas" class="btn btn-outline-primary"><i class="bi bi-calendar-check me-1"></i> Ver historial</a>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
