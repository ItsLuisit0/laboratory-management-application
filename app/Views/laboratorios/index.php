<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 fade-in-up">
    <div>
        <h2 class="fw-bold mb-1">Gestión de Laboratorios</h2>
        <p class="text-muted mb-0" style="font-size:0.88rem"><?= count($laboratorios ?? []) ?> laboratorios registrados</p>
    </div>
    <a href="/laboratorios/crear" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Nuevo Laboratorio
    </a>
</div>

<?php if (!empty($laboratorios)): ?>
<div class="row g-4">
    <?php foreach ($laboratorios as $lab): ?>
    <div class="col-lg-4 col-md-6">
        <div class="card shadow-sm h-100" style="transition: all 0.3s cubic-bezier(0.4,0,0.2,1)">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="width:50px;height:50px;background:linear-gradient(135deg,#3b82f6,#6366f1);color:#fff;font-size:1.3rem;">
                        <i class="bi bi-building-fill"></i>
                    </div>
                    <?php
                        $estadoClass = match($lab['estado'] ?? '') {
                            'DISPONIBLE' => 'bg-success',
                            'MANTENIMIENTO' => 'bg-warning text-dark',
                            default => 'bg-secondary'
                        };
                    ?>
                    <span class="badge <?= $estadoClass ?>"><?= esc($lab['estado'] ?? 'N/A') ?></span>
                </div>
                <h5 class="fw-bold mb-1"><?= esc($lab['nombre']) ?></h5>
                <p class="text-muted mb-3" style="font-size:0.85rem"><?= esc($lab['descripcion'] ?? 'Sin descripción') ?></p>

                <div class="d-flex gap-3 text-muted mb-3" style="font-size:0.82rem">
                    <span><i class="bi bi-geo-alt-fill me-1 text-primary"></i><?= esc($lab['ubicacion'] ?? 'N/A') ?></span>
                    <span><i class="bi bi-people-fill me-1 text-info"></i><?= esc($lab['capacidad'] ?? 0) ?> pers.</span>
                </div>

                <div class="d-flex gap-2">
                    <a href="/laboratorios/editar/<?= $lab['id_laboratorio'] ?>" class="btn btn-sm btn-outline-primary flex-fill">
                        <i class="bi bi-pencil-fill me-1"></i> Editar
                    </a>
                    <a href="/laboratorios/eliminar/<?= $lab['id_laboratorio'] ?>" class="btn btn-sm btn-outline-danger btn-delete-confirm"
                       data-msg="¿Eliminar el laboratorio <?= esc($lab['nombre']) ?>? Esta acción no se puede deshacer.">
                        <i class="bi bi-trash-fill"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="card shadow-sm">
    <div class="card-body text-center py-5">
        <i class="bi bi-building display-3 text-muted d-block mb-3"></i>
        <h4 class="text-muted">No hay laboratorios registrados</h4>
        <a href="/laboratorios/crear" class="btn btn-primary mt-2"><i class="bi bi-plus-lg me-1"></i> Agregar Laboratorio</a>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
