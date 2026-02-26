<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 fade-in-up">
    <div>
        <h2 class="fw-bold mb-1">Detalle de Reserva #<?= esc($reserva['id_reserva']) ?></h2>
        <p class="text-muted mb-0" style="font-size:0.85rem">Información completa de la reserva y práctica asociada</p>
    </div>
    <a href="/reservas" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Volver
    </a>
</div>

<!-- Status Badge Row -->
<div class="mb-4 fade-in-up">
    <?php
        $statusConf = match($reserva['estado']) {
            'APROBADA'   => ['bg' => 'linear-gradient(135deg,#115c38,#1a7a4c)', 'icon' => 'bi-check-circle-fill', 'label' => 'Reserva Aprobada'],
            'COMPLETADA' => ['bg' => 'linear-gradient(135deg,#1b2838,#243347)', 'icon' => 'bi-check-all', 'label' => 'Reserva Completada'],
            'RECHAZADA'  => ['bg' => 'linear-gradient(135deg,#691b32,#8a2445)', 'icon' => 'bi-x-circle-fill', 'label' => 'Reserva Rechazada'],
            'CANCELADA'  => ['bg' => 'linear-gradient(135deg,#4b5563,#6b7280)', 'icon' => 'bi-slash-circle-fill', 'label' => 'Reserva Cancelada'],
            default      => ['bg' => 'linear-gradient(135deg,#92400e,#b45309)', 'icon' => 'bi-clock-fill', 'label' => 'Pendiente de Aprobación'],
        };
    ?>
    <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:<?= $statusConf['bg'] ?>;color:#fff">
        <i class="bi <?= $statusConf['icon'] ?>" style="font-size:1.3rem"></i>
        <div>
            <strong style="font-size:0.95rem"><?= $statusConf['label'] ?></strong>
            <?php if (!empty($reserva['aprobador_nombre'])): ?>
            <small class="d-block" style="opacity:0.8">
                Por <?= esc($reserva['aprobador_nombre']) ?>
                <?= !empty($reserva['fecha_aprobacion']) ? '· ' . esc($reserva['fecha_aprobacion']) : '' ?>
            </small>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Two Equal Cards -->
<div class="row g-4">

    <!-- Card 1: Reservation Info -->
    <div class="col-lg-6">
        <div class="card shadow-sm h-100 fade-in-up">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid #eef2f7">
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="width:44px;height:44px;background:linear-gradient(135deg,#115c38,#1a7a4c);color:#fff;font-size:1.1rem;">
                        <i class="bi bi-building-fill"></i>
                    </div>
                    <div>
                        <strong style="font-size:0.95rem">Información de la Reserva</strong>
                        <small class="text-muted d-block">Datos del laboratorio y horario</small>
                    </div>
                </div>

                <div class="flex-fill">
                    <!-- Lab -->
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-3" style="background:#f5f8f6;border-left:3px solid #1a7a4c">
                        <i class="bi bi-building-fill" style="color:#1a7a4c;font-size:1rem"></i>
                        <div>
                            <small class="text-muted d-block" style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.6px">Laboratorio</small>
                            <strong style="font-size:0.92rem"><?= esc($reserva['laboratorio_nombre']) ?></strong>
                        </div>
                    </div>

                    <!-- Teacher -->
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-3" style="background:#f5f8f6;border-left:3px solid #1a7a4c">
                        <i class="bi bi-person-fill" style="color:#1a7a4c;font-size:1rem"></i>
                        <div>
                            <small class="text-muted d-block" style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.6px">Solicitante</small>
                            <strong style="font-size:0.92rem"><?= esc($reserva['usuario_nombre']) ?></strong>
                        </div>
                    </div>

                    <!-- Date & Time -->
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background:#f5f8f6;border-left:3px solid #1a7a4c">
                                <small class="text-muted d-block" style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.6px">
                                    <i class="bi bi-calendar-fill me-1" style="color:#1a7a4c"></i> Fecha
                                </small>
                                <strong style="font-size:0.92rem"><?= esc($reserva['fecha']) ?></strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded-3" style="background:#f5f8f6;border-left:3px solid #1a7a4c">
                                <small class="text-muted d-block" style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.6px">
                                    <i class="bi bi-clock-fill me-1" style="color:#1a7a4c"></i> Horario
                                </small>
                                <strong style="font-size:0.92rem"><?= esc($reserva['hora_inicio']) ?> — <?= esc($reserva['hora_fin']) ?></strong>
                            </div>
                        </div>
                    </div>

                    <!-- Group Info -->
                    <?php if (!empty($reserva['semestre']) || !empty($reserva['carrera']) || !empty($reserva['total_alumnos'])): ?>
                    <div class="row g-3 mt-0">
                        <div class="col-4">
                            <div class="p-3 rounded-3" style="background:#f5f8f6;border-left:3px solid #1a7a4c">
                                <small class="text-muted d-block" style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.6px">
                                    <i class="bi bi-mortarboard-fill me-1" style="color:#1a7a4c"></i> Semestre
                                </small>
                                <strong style="font-size:0.92rem"><?= esc($reserva['semestre'] ?? 'N/A') ?>°</strong>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 rounded-3" style="background:#f5f8f6;border-left:3px solid #1a7a4c">
                                <small class="text-muted d-block" style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.6px">
                                    <i class="bi bi-book-fill me-1" style="color:#1a7a4c"></i> Carrera
                                </small>
                                <strong style="font-size:0.92rem"><?= esc($reserva['carrera'] ?? 'N/A') ?></strong>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 rounded-3" style="background:#f5f8f6;border-left:3px solid #1a7a4c">
                                <small class="text-muted d-block" style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.6px">
                                    <i class="bi bi-people-fill me-1" style="color:#1a7a4c"></i> Alumnos
                                </small>
                                <strong style="font-size:0.92rem"><?= esc($reserva['total_alumnos'] ?? 0) ?></strong>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Practice Content -->
    <div class="col-lg-6">
        <div class="card shadow-sm h-100 fade-in-up">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid #eef2f7">
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="width:44px;height:44px;background:linear-gradient(135deg,#115c38,#1a7a4c);color:#fff;font-size:1.1rem;">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <div>
                        <strong style="font-size:0.95rem">Contenido de la Práctica</strong>
                        <small class="text-muted d-block">Descripción y materiales requeridos</small>
                    </div>
                </div>

                <div class="flex-fill">
                    <?php if (!empty($practica)): ?>
                    <!-- Practice Description -->
                    <div class="p-3 rounded-3 mb-3" style="background:#f5f8f6;border-left:3px solid #1a7a4c">
                        <small class="fw-bold text-uppercase d-block mb-2" style="font-size:0.68rem;letter-spacing:0.8px;color:#1a7a4c">
                            <i class="bi bi-file-text-fill me-1"></i> Descripción de la Práctica
                        </small>
                        <p class="mb-0" style="font-size:0.88rem;line-height:1.7;color:#334155"><?= nl2br(esc($practica['contenido'])) ?></p>
                    </div>

                    <!-- Requirements -->
                    <?php if (!empty($practica['requerimientos'])): ?>
                    <div class="p-3 rounded-3" style="background:#f5f8f6;border-left:3px solid #1a7a4c">
                        <small class="fw-bold text-uppercase d-block mb-2" style="font-size:0.68rem;letter-spacing:0.8px;color:#1a7a4c">
                            <i class="bi bi-tools me-1"></i> Requerimientos / Materiales
                        </small>
                        <p class="mb-0" style="font-size:0.88rem;line-height:1.7;color:#334155"><?= nl2br(esc($practica['requerimientos'])) ?></p>
                    </div>
                    <?php else: ?>
                    <div class="p-3 rounded-3 text-center" style="background:#f5f8f6">
                        <small class="text-muted"><i class="bi bi-info-circle me-1"></i> Sin requerimientos especificados</small>
                    </div>
                    <?php endif; ?>

                    <?php else: ?>
                    <!-- No practice -->
                    <div class="text-center py-4">
                        <div class="rounded-3 d-flex align-items-center justify-content-center mx-auto mb-3"
                             style="width:52px;height:52px;background:#f5f8f6;color:#94a3b8;font-size:1.3rem;border-radius:14px!important">
                            <i class="bi bi-journal-x"></i>
                        </div>
                        <h6 class="text-muted fw-bold mb-1">Sin práctica asociada</h6>
                        <p class="text-muted mb-0" style="font-size:0.82rem">No se registró información de práctica para esta reserva.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
