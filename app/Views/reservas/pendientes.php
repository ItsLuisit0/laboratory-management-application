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
            <hr class="text-muted opacity-25 my-4">
            <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-journal-check me-2"></i>Detalles de la Práctica</h5>
            <div class="row g-4 mb-2">
                <div class="col-md-6">
                    <div class="h-100 p-4 bg-white rounded shadow-sm border-top border-4 border-primary">
                        <h6 class="fw-bold text-uppercase text-muted mb-3 fs-7" style="letter-spacing: 0.5px;">Contenido</h6>
                        <p class="mb-0 text-dark" style="line-height: 1.6;"><?= nl2br(esc($r['contenido'])) ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="h-100 p-4 bg-white rounded shadow-sm border-top border-4 border-info">
                        <h6 class="fw-bold text-uppercase text-muted mb-3 fs-7" style="letter-spacing: 0.5px;">Requerimientos / Materiales</h6>
                        <?php if (!empty($r['requerimientos'])): ?>
                            <p class="mb-0 text-dark" style="line-height: 1.6;"><?= nl2br(esc($r['requerimientos'])) ?></p>
                        <?php else: ?>
                            <div class="d-flex align-items-center text-muted h-100">
                                <em><i class="bi bi-dash-circle me-1"></i> Sin requerimientos adicionales</em>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <hr class="text-muted opacity-25 my-4">
            <div class="alert alert-warning border-0 shadow-sm mb-2 d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-3 me-3 text-warning"></i>
                <div>
                    <h6 class="fw-bold mb-1">Falta Información de Práctica</h6>
                    <p class="mb-0 text-muted small">El docente no adjuntó contenido ni requerimientos para esta solicitud.</p>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="card-footer bg-light p-3 d-flex justify-content-between align-items-center border-top-0">
            <span class="text-muted small"><i class="bi bi-info-circle me-1"></i> Revisa los detalles antes de tomar una decisión.</span>
            <div class="d-flex gap-2">
                <form action="/reservas/rechazar/<?= $r['id_reserva'] ?>" method="post" data-confirm="¿Estás seguro de RECHAZAR esta solicitud?">
                    <button class="btn btn-outline-danger px-4 fw-bold" type="submit">
                        <i class="bi bi-x-circle me-1"></i> Rechazar
                    </button>
                </form>
                <form action="/reservas/aprobar/<?= $r['id_reserva'] ?>" method="post" data-confirm="¿Estás seguro de APROBAR esta solicitud? El horario se reservará oficialmente.">
                    <button class="btn btn-success px-4 fw-bold shadow-sm" type="submit">
                        <i class="bi bi-check-circle me-1"></i> Aprobar Reserva
                    </button>
                </form>
            </div>
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
