<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 fade-in-up">
    <div>
        <h2 class="fw-bold mb-1">Generar Reporte</h2>
        <p class="text-muted mb-0" style="font-size:0.88rem">Configura los filtros y genera un reporte en PDF</p>
    </div>
    <a href="/reportes/historial" class="btn btn-outline-primary">
        <i class="bi bi-clock-history me-1"></i> Historial
    </a>
</div>

<div class="card shadow-sm fade-in-up">
    <div class="card-body">
        <form action="/reportes/generar" method="post" target="_blank">
            <h6 class="fw-bold mb-3"><i class="bi bi-funnel-fill me-2 text-primary"></i>Filtros del Reporte</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="id_laboratorio" class="form-label fw-semibold">Laboratorio</label>
                    <select class="form-select" id="id_laboratorio" name="id_laboratorio">
                        <option value="">Todos los laboratorios</option>
                        <?php foreach ($laboratorios as $id => $nombre): ?>
                        <option value="<?= $id ?>"><?= esc($nombre) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="id_maestro" class="form-label fw-semibold">Maestro</label>
                    <select class="form-select" id="id_maestro" name="id_maestro">
                        <option value="">Todos los maestros</option>
                        <?php foreach ($maestros as $m): ?>
                        <option value="<?= $m['id_usuario'] ?>"><?= esc($m['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="fecha_inicio" class="form-label fw-semibold">Fecha Inicio</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                </div>
                <div class="col-md-4">
                    <label for="fecha_fin" class="form-label fw-semibold">Fecha Fin</label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                </div>
                <div class="col-md-4">
                    <label for="estado" class="form-label fw-semibold">Estado</label>
                    <select class="form-select" id="estado" name="estado">
                        <option value="">Todos</option>
                        <option value="PENDIENTE">Pendiente</option>
                        <option value="APROBADA">Aprobada</option>
                        <option value="RECHAZADA">Rechazada</option>
                    </select>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Generar PDF
            </button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
