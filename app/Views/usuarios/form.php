<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 fade-in-up">
    <h2 class="fw-bold mb-0"><?= isset($usuario) ? 'Editar' : 'Nuevo' ?> Usuario</h2>
    <a href="/usuarios" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Volver
    </a>
</div>

<div class="card shadow-sm fade-in-up" style="max-width:700px">
    <div class="card-body">
        <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid #eef2f7">
            <div class="rounded-3 d-flex align-items-center justify-content-center"
                 style="width:48px;height:48px;background:linear-gradient(135deg,#3b82f6,#6366f1);color:#fff;font-size:1.2rem;">
                <i class="bi bi-person-fill"></i>
            </div>
            <div>
                <strong>Datos del usuario</strong>
                <small class="text-muted d-block">Completa todos los campos requeridos</small>
            </div>
        </div>

        <form action="<?= isset($usuario) ? '/usuarios/update/' . $usuario['id_usuario'] : '/usuarios/store' ?>" method="post">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label fw-semibold">Nombre completo <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required
                           value="<?= esc($usuario['nombre'] ?? old('nombre')) ?>">
                </div>
                <div class="col-md-6">
                    <label for="correo" class="form-label fw-semibold">Correo electrónico <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="correo" name="correo" required
                           value="<?= esc($usuario['correo'] ?? old('correo')) ?>">
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label fw-semibold">Contraseña <?= isset($usuario) ? '' : '<span class="text-danger">*</span>' ?></label>
                    <input type="password" class="form-control" id="password" name="password"
                           <?= isset($usuario) ? 'placeholder="Dejar vacío para mantener"' : 'required' ?>>
                </div>
                <div class="col-md-3">
                    <label for="id_rol" class="form-label fw-semibold">Rol <span class="text-danger">*</span></label>
                    <select class="form-select" id="id_rol" name="id_rol" required>
                        <option value="">Seleccione</option>
                        <?php foreach ($roles as $r): ?>
                        <option value="<?= $r['id_rol'] ?>" <?= (($usuario['id_rol'] ?? old('id_rol')) == $r['id_rol']) ? 'selected' : '' ?>>
                            <?= esc($r['nombre']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="estado" class="form-label fw-semibold">Estado</label>
                    <select class="form-select" id="estado" name="estado">
                        <option value="ACTIVO" <?= (($usuario['estado'] ?? 'ACTIVO') === 'ACTIVO') ? 'selected' : '' ?>>Activo</option>
                        <option value="INACTIVO" <?= (($usuario['estado'] ?? '') === 'INACTIVO') ? 'selected' : '' ?>>Inactivo</option>
                    </select>
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> <?= isset($usuario) ? 'Actualizar' : 'Crear Usuario' ?>
                </button>
                <a href="/usuarios" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
