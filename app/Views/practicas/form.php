<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0"><?= esc($title) ?></h2>
    <a href="/practicas" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Volver
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <?php if (isset($reserva)): ?>
        <div class="alert alert-info mb-4">
            <i class="bi bi-info-circle-fill me-2"></i>
            <strong>Reserva #<?= esc($reserva['id_reserva']) ?></strong> — 
            Fecha: <?= esc($reserva['fecha']) ?> | 
            Horario: <?= esc($reserva['hora_inicio']) ?> - <?= esc($reserva['hora_fin']) ?>
        </div>
        <?php endif; ?>

        <form action="<?= isset($practica) ? '/practicas/update/' . $practica['id_practica'] : '/practicas/store' ?>" method="post">
            <?php if (!isset($practica) && isset($reserva)): ?>
            <input type="hidden" name="id_reserva" value="<?= esc($reserva['id_reserva']) ?>">
            <?php endif; ?>

            <div class="row g-3">
                <div class="col-12">
                    <label for="contenido" class="form-label fw-semibold">Contenido de la Práctica <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="contenido" name="contenido" rows="5" required
                              minlength="5" placeholder="Descripción detallada del contenido de la práctica..."><?= esc($practica['contenido'] ?? old('contenido')) ?></textarea>
                </div>
                <div class="col-12">
                    <label for="requerimientos" class="form-label fw-semibold">Requerimientos</label>
                    <textarea class="form-control" id="requerimientos" name="requerimientos" rows="3"
                              placeholder="Software, hardware, materiales necesarios..."><?= esc($practica['requerimientos'] ?? old('requerimientos')) ?></textarea>
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>
                    <?= isset($practica) ? 'Actualizar' : 'Registrar Práctica' ?>
                </button>
                <a href="/practicas" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
