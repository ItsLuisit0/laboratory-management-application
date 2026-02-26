<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 fade-in-up">
    <div>
        <h2 class="fw-bold mb-1">
            <?php if (strtoupper($user['rol_nombre'] ?? '') === 'MAESTRO'): ?>
                Mis Prácticas
            <?php else: ?>
                Prácticas Registradas
            <?php endif; ?>
        </h2>
        <p class="text-muted mb-0" style="font-size:0.88rem"><?= count($practicas ?? []) ?> práctica<?= count($practicas ?? []) !== 1 ? 's' : '' ?></p>
    </div>
</div>

<?php if (!empty($practicas)): ?>
<div class="row g-3">
    <?php foreach ($practicas as $p): ?>
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:44px;height:44px;background:linear-gradient(135deg,#06b6d4,#0891b2);color:#fff;font-size:1.1rem;">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <div>
                        <strong>Práctica #<?= esc($p['id_practica']) ?></strong>
                        <span class="text-muted d-block" style="font-size:0.8rem">Reserva #<?= esc($p['id_reserva']) ?></span>
                    </div>
                </div>

                <div class="p-3 rounded-3 mb-3" style="background:#f8fafc;border-left:3px solid #3b82f6;">
                    <small class="fw-bold text-uppercase text-muted d-block mb-1" style="font-size:0.68rem;letter-spacing:0.8px">Contenido</small>
                    <p class="mb-0" style="font-size:0.88rem"><?= nl2br(esc($p['contenido'] ?? 'Sin contenido')) ?></p>
                </div>

                <?php if (!empty($p['requerimientos'])): ?>
                <div class="p-3 rounded-3" style="background:#f0fdf4;border-left:3px solid #10b981;">
                    <small class="fw-bold text-uppercase text-muted d-block mb-1" style="font-size:0.68rem;letter-spacing:0.8px">Requerimientos</small>
                    <p class="mb-0" style="font-size:0.88rem"><?= nl2br(esc($p['requerimientos'])) ?></p>
                </div>
                <?php endif; ?>

                <div class="text-muted mt-3" style="font-size:0.78rem">
                    <i class="bi bi-clock me-1"></i> <?= esc($p['fecha_registro'] ?? 'N/A') ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="card shadow-sm">
    <div class="card-body text-center py-5">
        <i class="bi bi-journal-x display-3 text-muted d-block mb-3"></i>
        <h4 class="text-muted">No hay prácticas registradas</h4>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
