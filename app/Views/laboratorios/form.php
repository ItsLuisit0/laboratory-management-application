<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 fade-in-up">
    <h2 class="fw-bold mb-0"><?= isset($laboratorio) ? 'Editar' : 'Nuevo' ?> Laboratorio</h2>
    <a href="/laboratorios" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Volver
    </a>
</div>

<div class="card shadow-sm fade-in-up" style="max-width:700px">
    <div class="card-body">
        <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid #eef2f7">
            <div class="rounded-3 d-flex align-items-center justify-content-center"
                 style="width:48px;height:48px;background:linear-gradient(135deg,#06b6d4,#0891b2);color:#fff;font-size:1.2rem;">
                <i class="bi bi-building-fill"></i>
            </div>
            <div>
                <strong>Datos del laboratorio</strong>
                <small class="text-muted d-block">Completa la información del laboratorio</small>
            </div>
        </div>

        <form action="<?= isset($laboratorio) ? '/laboratorios/update/' . $laboratorio['id_laboratorio'] : '/laboratorios/store' ?>" method="post">
            <div class="row g-3">
                <div class="col-md-8">
                    <label for="nombre" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required
                           placeholder="Ej: Lab. Redes y Telecomunicaciones"
                           value="<?= esc($laboratorio['nombre'] ?? old('nombre')) ?>">
                </div>
                <div class="col-md-4">
                    <label for="capacidad" class="form-label fw-semibold">Capacidad</label>
                    <input type="number" class="form-control" id="capacidad" name="capacidad" min="1"
                           placeholder="30"
                           value="<?= esc($laboratorio['capacidad'] ?? old('capacidad')) ?>">
                </div>
                <div class="col-md-6">
                    <label for="ubicacion" class="form-label fw-semibold">Ubicación</label>
                    <input type="text" class="form-control" id="ubicacion" name="ubicacion"
                           placeholder="Ej: Edificio C, Planta Baja"
                           value="<?= esc($laboratorio['ubicacion'] ?? old('ubicacion')) ?>">
                </div>
                <div class="col-md-6">
                    <label for="estado" class="form-label fw-semibold">Estado</label>
                    <select class="form-select" id="estado" name="estado">
                        <option value="DISPONIBLE" <?= (($laboratorio['estado'] ?? 'DISPONIBLE') === 'DISPONIBLE') ? 'selected' : '' ?>>Disponible</option>
                        <option value="MANTENIMIENTO" <?= (($laboratorio['estado'] ?? '') === 'MANTENIMIENTO') ? 'selected' : '' ?>>En Mantenimiento</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                              placeholder="Equipamiento disponible, software instalado..."><?= esc($laboratorio['descripcion'] ?? old('descripcion')) ?></textarea>
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> <?= isset($laboratorio) ? 'Actualizar' : 'Crear Laboratorio' ?>
                </button>
                <a href="/laboratorios" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
