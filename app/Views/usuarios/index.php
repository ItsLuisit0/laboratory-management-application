<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 fade-in-up">
    <div>
        <h2 class="fw-bold mb-1">Gestión de Usuarios</h2>
        <p class="text-muted mb-0" style="font-size:0.88rem"><?= count($usuarios ?? []) ?> usuarios registrados</p>
    </div>
    <a href="/usuarios/crear" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Nuevo Usuario
    </a>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <?php
        $activos = count(array_filter($usuarios ?? [], fn($u) => ($u['estado'] ?? '') === 'ACTIVO'));
        $inactivos = count($usuarios ?? []) - $activos;
    ?>
    <div class="col-md-4">
        <div class="stat-card stat-primary">
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
            <div class="stat-info">
                <span class="stat-value"><?= count($usuarios ?? []) ?></span>
                <span class="stat-label">Total Usuarios</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card stat-success">
            <div class="stat-icon"><i class="bi bi-check-circle-fill"></i></div>
            <div class="stat-info">
                <span class="stat-value"><?= $activos ?></span>
                <span class="stat-label">Activos</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card stat-warning">
            <div class="stat-icon"><i class="bi bi-pause-circle-fill"></i></div>
            <div class="stat-info">
                <span class="stat-value"><?= $inactivos ?></span>
                <span class="stat-label">Inactivos</span>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:50px">#</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($usuarios)): ?>
                        <?php foreach ($usuarios as $u): ?>
                        <tr>
                            <td><span class="fw-bold text-muted"><?= esc($u['id_usuario']) ?></span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                         style="width:36px;height:36px;background:linear-gradient(135deg,#3b82f6,#6366f1);color:#fff;font-size:0.85rem;font-weight:700;">
                                        <?= strtoupper(substr($u['nombre'], 0, 1)) ?>
                                    </div>
                                    <strong><?= esc($u['nombre']) ?></strong>
                                </div>
                            </td>
                            <td><span class="text-muted"><?= esc($u['correo']) ?></span></td>
                            <td>
                                <?php
                                    $rolColors = ['ADMIN' => 'bg-danger', 'JEFE' => 'bg-primary', 'MAESTRO' => 'bg-info', 'ALUMNO' => 'bg-secondary'];
                                    $bc = $rolColors[$u['rol_nombre'] ?? ''] ?? 'bg-secondary';
                                ?>
                                <span class="badge <?= $bc ?>"><?= esc($u['rol_nombre'] ?? 'N/A') ?></span>
                            </td>
                            <td>
                                <?php if (($u['estado'] ?? '') === 'ACTIVO'): ?>
                                    <span class="badge bg-success"><i class="bi bi-circle-fill me-1" style="font-size:0.5rem"></i>Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><i class="bi bi-circle-fill me-1" style="font-size:0.5rem"></i>Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="/usuarios/editar/<?= $u['id_usuario'] ?>" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Editar">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <a href="/usuarios/eliminar/<?= $u['id_usuario'] ?>" class="btn btn-sm btn-outline-danger btn-delete-confirm"
                                       data-msg="¿Eliminar al usuario <?= esc($u['nombre']) ?>? Esta acción no se puede deshacer." data-bs-toggle="tooltip" title="Eliminar">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-people display-5 d-block mb-2"></i>No hay usuarios registrados.
                        </td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
