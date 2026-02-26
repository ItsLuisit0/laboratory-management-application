<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 fade-in-up">
    <div>
        <h2 class="fw-bold mb-1">Historial de Reportes</h2>
        <p class="text-muted mb-0" style="font-size:0.88rem"><?= count($reportes ?? []) ?> reporte<?= count($reportes ?? []) !== 1 ? 's' : '' ?> generados</p>
    </div>
    <a href="/reportes" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Nuevo Reporte
    </a>
</div>

<?php if (!empty($reportes)): ?>
<div class="row g-3">
    <?php foreach ($reportes as $r): ?>
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:44px;height:44px;background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;font-size:1rem;">
                        <i class="bi bi-file-earmark-pdf-fill"></i>
                    </div>
                    <div class="flex-fill">
                        <strong>Reporte #<?= esc($r['id_reporte']) ?></strong>
                        <small class="text-muted d-block mb-2"><?= esc($r['fecha_generacion'] ?? '') ?></small>
                        <?php if (!empty($r['parametros'])): ?>
                        <div class="p-2 rounded-2" style="background:#f8fafc;font-size:0.8rem">
                            <code style="color:#64748b"><?= esc($r['parametros']) ?></code>
                        </div>
                        <?php endif; ?>
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
        <i class="bi bi-file-earmark-x display-3 text-muted d-block mb-3"></i>
        <h4 class="text-muted">No hay reportes generados</h4>
        <a href="/reportes" class="btn btn-primary mt-2"><i class="bi bi-plus-lg me-1"></i> Generar primer reporte</a>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
