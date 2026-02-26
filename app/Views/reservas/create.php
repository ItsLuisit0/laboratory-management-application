<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 fade-in-up">
    <div>
        <h2 class="fw-bold mb-1">Solicitar Reserva de Laboratorio</h2>
        <p class="text-muted mb-0" style="font-size:0.85rem">Complete el formulario para enviar su solicitud al jefe de carrera</p>
    </div>
    <a href="/reservas" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Mis Reservas
    </a>
</div>

<!-- ── Conflict Suggestions Panel ──────────────── -->
<?php if (!empty($conflicto)): ?>
<div class="card shadow-sm mb-4 fade-in-up" style="border-left:4px solid #691b32;border-color:#691b32">
    <div class="card-body">
        <div class="d-flex align-items-start gap-3 mb-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                 style="width:48px;height:48px;background:linear-gradient(135deg,#691b32,#8a2445);color:#fff;font-size:1.2rem">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-1" style="color:#691b32">Horario no disponible</h5>
                <p class="text-muted mb-0" style="font-size:0.88rem">
                    El laboratorio <strong><?= esc($lab_conflicto ?? '') ?></strong> ya tiene una reserva el
                    <strong><?= esc($fecha_conflicto ?? '') ?></strong> en el horario solicitado.
                </p>
            </div>
        </div>

        <div class="row g-3">
            <!-- Available time slots -->
            <div class="col-md-6">
                <div class="p-3 rounded-3" style="background:#f5f8f6;border:1px solid #e2e8e5">
                    <h6 class="fw-bold mb-2" style="font-size:0.82rem;color:#1a7a4c">
                        <i class="bi bi-clock-fill me-1"></i> Horarios disponibles · <?= esc($fecha_conflicto ?? '') ?>
                    </h6>
                    <?php if (!empty($horarios_disponibles)): ?>
                    <div class="d-flex flex-column gap-2">
                        <?php foreach ($horarios_disponibles as $h): ?>
                        <a href="#" class="d-flex justify-content-between align-items-center p-2 rounded-2 text-decoration-none suggestion-slot"
                           data-hora-inicio="<?= $h['hora_inicio'] ?>" data-hora-fin="<?= $h['hora_fin'] ?>"
                           data-fecha="<?= esc($fecha_conflicto ?? '') ?>"
                           style="background:#fff;border:1px solid #e2e8e5;color:#1e293b;transition:all 0.2s ease">
                            <span>
                                <i class="bi bi-check-circle-fill me-1" style="color:#1a7a4c"></i>
                                <strong><?= esc($h['hora_inicio']) ?></strong> — <strong><?= esc($h['hora_fin']) ?></strong>
                            </span>
                            <span class="badge" style="background:#1a7a4c;font-size:0.65rem">Disponible</span>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <p class="text-muted mb-0 text-center py-2" style="font-size:0.82rem">
                        <i class="bi bi-calendar-x me-1"></i> Sin horarios disponibles
                    </p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Alternative days -->
            <div class="col-md-6">
                <div class="p-3 rounded-3" style="background:#f5f7fa;border:1px solid #e2e5ee">
                    <h6 class="fw-bold mb-2" style="font-size:0.82rem;color:#2e6da4">
                        <i class="bi bi-calendar-week-fill me-1"></i> Días alternativos cercanos
                    </h6>
                    <?php if (!empty($dias_disponibles)): ?>
                    <div class="d-flex flex-column gap-2">
                        <?php foreach ($dias_disponibles as $d): ?>
                        <a href="#" class="d-flex justify-content-between align-items-center p-2 rounded-2 text-decoration-none suggestion-day"
                           data-fecha="<?= $d['fecha'] ?>"
                           style="background:#fff;border:1px solid #e2e5ee;color:#1e293b;transition:all 0.2s ease">
                            <span>
                                <i class="bi bi-calendar-check-fill me-1" style="color:#2e6da4"></i>
                                <strong><?= esc($d['dia_nombre']) ?></strong>
                            </span>
                            <?php if ($d['reservas_activas'] == 0): ?>
                                <span class="badge" style="background:#1a7a4c;font-size:0.65rem">Libre</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark" style="font-size:0.65rem"><?= $d['reservas_activas'] ?> reserva<?= $d['reservas_activas'] > 1 ? 's' : '' ?></span>
                            <?php endif; ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <p class="text-muted mb-0 text-center py-2" style="font-size:0.82rem">
                        <i class="bi bi-calendar-x me-1"></i> Sin días alternativos
                    </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="mt-3 p-2 rounded-2 d-flex align-items-center gap-2" style="background:rgba(245,158,11,0.08);font-size:0.82rem;color:#92400e">
            <i class="bi bi-lightbulb-fill"></i>
            <span><strong>Tip:</strong> Haz clic en un horario o día sugerido para aplicarlo automáticamente al formulario.</span>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- ── Main Form ───────────────────────────────── -->
<form action="/reservas/store" method="post" id="reservaForm">
    <div class="row g-4">

        <!-- Left Column: Reservation Details -->
        <div class="col-lg-7">
            <!-- Step 1: Lab & Schedule -->
            <div class="card shadow-sm mb-4 fade-in-up">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid #eef2f7">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:36px;height:36px;background:linear-gradient(135deg,#115c38,#1a7a4c);color:#fff;font-size:0.85rem;font-weight:800">
                            1
                        </div>
                        <div>
                            <strong style="font-size:0.95rem">Laboratorio y Horario</strong>
                            <small class="text-muted d-block">Seleccione el laboratorio, fecha y hora</small>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="id_laboratorio" class="form-label fw-semibold">
                                <i class="bi bi-building-fill me-1" style="color:#1a7a4c"></i> Laboratorio <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="id_laboratorio" name="id_laboratorio" required>
                                <option value="">Seleccione un laboratorio</option>
                                <?php foreach ($laboratorios as $id => $nombre): ?>
                                <option value="<?= $id ?>" <?= (old('id_laboratorio') == $id) ? 'selected' : '' ?>>
                                    <?= esc($nombre) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="fecha" class="form-label fw-semibold">
                                <i class="bi bi-calendar-fill me-1" style="color:#1a7a4c"></i> Fecha <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="fecha" name="fecha" required
                                   placeholder="Seleccione una fecha" readonly
                                   value="<?= old('fecha') ?>"
                                   style="cursor:pointer;background:#fff">
                        </div>
                        <div class="col-6">
                            <label for="hora_inicio" class="form-label fw-semibold">
                                <i class="bi bi-clock-fill me-1" style="color:#1a7a4c"></i> Hora Inicio <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="hora_inicio" name="hora_inicio" required
                                   placeholder="Seleccione hora" readonly
                                   value="<?= old('hora_inicio') ?>"
                                   style="cursor:pointer;background:#fff">
                        </div>
                        <div class="col-6">
                            <label for="hora_fin" class="form-label fw-semibold">
                                <i class="bi bi-clock-history me-1" style="color:#1a7a4c"></i> Hora Fin <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="hora_fin" name="hora_fin" required
                                   placeholder="Seleccione hora" readonly
                                   value="<?= old('hora_fin') ?>"
                                   style="cursor:pointer;background:#fff">
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center gap-2 p-2 rounded-2" style="background:#f5f8f6;font-size:0.78rem;color:#475569">
                                <i class="bi bi-info-circle-fill" style="color:#1a7a4c"></i>
                                <span>Horario permitido: <strong>7:00 AM — 4:00 PM</strong> (Lunes a Viernes)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Group Info -->
            <div class="card shadow-sm mb-4 fade-in-up">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid #eef2f7">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:36px;height:36px;background:linear-gradient(135deg,#115c38,#1a7a4c);color:#fff;font-size:0.85rem;font-weight:800">
                            2
                        </div>
                        <div>
                            <strong style="font-size:0.95rem">Información del Grupo</strong>
                            <small class="text-muted d-block">Semestre, carrera y alumnos</small>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="semestre" class="form-label fw-semibold">
                                <i class="bi bi-mortarboard-fill me-1" style="color:#1a7a4c"></i> Semestre <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="semestre" name="semestre" required>
                                <option value="">Seleccione</option>
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?= $i ?>" <?= old('semestre') == $i ? 'selected' : '' ?>><?= $i ?>° Semestre</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="carrera" class="form-label fw-semibold">
                                <i class="bi bi-book-fill me-1" style="color:#1a7a4c"></i> Carrera <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="carrera" name="carrera" required>
                                <option value="">Seleccione</option>
                                <option value="ISC" <?= old('carrera') == 'ISC' ? 'selected' : '' ?>>Ing. Sistemas Computacionales</option>
                                <option value="IGE" <?= old('carrera') == 'IGE' ? 'selected' : '' ?>>Ing. Gestión Empresarial</option>
                                <option value="IIA" <?= old('carrera') == 'IIA' ? 'selected' : '' ?>>Ing. Industrias Alimentarias</option>
                                <option value="IC" <?= old('carrera') == 'IC' ? 'selected' : '' ?>>Ing. Civil</option>
                                <option value="IE" <?= old('carrera') == 'IE' ? 'selected' : '' ?>>Ing. Electromecánica</option>
                                <option value="LA" <?= old('carrera') == 'LA' ? 'selected' : '' ?>>Lic. Administración</option>
                                <option value="CP" <?= old('carrera') == 'CP' ? 'selected' : '' ?>>Contador Público</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="total_alumnos" class="form-label fw-semibold">
                                <i class="bi bi-people-fill me-1" style="color:#1a7a4c"></i> Total de Alumnos <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" id="total_alumnos" name="total_alumnos" required
                                   min="1" max="50" placeholder="Ej: 30" value="<?= old('total_alumnos') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Practice content -->
            <div class="card shadow-sm fade-in-up">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid #eef2f7">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:36px;height:36px;background:linear-gradient(135deg,#115c38,#1a7a4c);color:#fff;font-size:0.85rem;font-weight:800">
                            3
                        </div>
                        <div>
                            <strong style="font-size:0.95rem">Contenido de la Práctica</strong>
                            <small class="text-muted d-block">Describa la actividad y requerimientos</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="contenido" class="form-label fw-semibold">
                            <i class="bi bi-journal-text me-1" style="color:#1a7a4c"></i> Descripción de la práctica <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="contenido" name="contenido" rows="4" required minlength="5"
                                  placeholder="Describa el contenido, objetivos y actividades de la práctica a realizar..."><?= old('contenido') ?></textarea>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">Mínimo 5 caracteres</small>
                            <small class="text-muted" id="contenidoCount">0 caracteres</small>
                        </div>
                    </div>

                    <div>
                        <label for="requerimientos" class="form-label fw-semibold">
                            <i class="bi bi-tools me-1" style="color:#1a7a4c"></i> Requerimientos / Materiales
                            <span class="badge bg-light text-muted ms-1" style="font-size:0.6rem;font-weight:600">Opcional</span>
                        </label>
                        <textarea class="form-control" id="requerimientos" name="requerimientos" rows="3"
                                  placeholder="Ej: Software MATLAB, 15 computadoras con acceso a internet, proyector..."><?= old('requerimientos') ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Summary & Submit -->
        <div class="col-lg-5">
            <div class="card shadow-sm fade-in-up" style="position:sticky;top:84px">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid #eef2f7">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:36px;height:36px;background:linear-gradient(135deg,#115c38,#1a7a4c);color:#fff;font-size:0.85rem;font-weight:800">
                            4
                        </div>
                        <div>
                            <strong style="font-size:0.95rem">Resumen y Envío</strong>
                            <small class="text-muted d-block">Verifique la información</small>
                        </div>
                    </div>

                    <!-- Live summary -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid #f1f5f9;font-size:0.85rem">
                            <span class="text-muted"><i class="bi bi-building me-1"></i> Laboratorio</span>
                            <strong id="summaryLab" class="text-end" style="max-width:60%">—</strong>
                        </div>
                        <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid #f1f5f9;font-size:0.85rem">
                            <span class="text-muted"><i class="bi bi-calendar me-1"></i> Fecha</span>
                            <strong id="summaryFecha">—</strong>
                        </div>
                        <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid #f1f5f9;font-size:0.85rem">
                            <span class="text-muted"><i class="bi bi-clock me-1"></i> Horario</span>
                            <strong id="summaryHorario">—</strong>
                        </div>
                        <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid #f1f5f9;font-size:0.85rem">
                            <span class="text-muted"><i class="bi bi-mortarboard me-1"></i> Grupo</span>
                            <span id="summaryGrupo" class="text-end" style="max-width:60%;font-size:0.82rem;color:#64748b">—</span>
                        </div>
                        <div class="d-flex justify-content-between py-2" style="font-size:0.85rem">
                            <span class="text-muted"><i class="bi bi-journal-text me-1"></i> Práctica</span>
                            <span id="summaryContenido" class="text-end" style="max-width:60%;font-size:0.82rem;color:#64748b">—</span>
                        </div>
                    </div>

                    <!-- Info box -->
                    <div class="p-3 rounded-3 mb-4" style="background:#f5f8f6;border:1px solid #e2e8e5">
                        <div class="d-flex gap-2 mb-2" style="font-size:0.8rem;color:#1a7a4c">
                            <i class="bi bi-info-circle-fill"></i>
                            <strong>¿Cómo funciona?</strong>
                        </div>
                        <ul class="mb-0 ps-3" style="font-size:0.78rem;color:#475569;line-height:1.7">
                            <li>Su solicitud será revisada por el <strong>Jefe de Carrera</strong></li>
                            <li>Recibirá una notificación al ser <strong>aprobada o rechazada</strong></li>
                            <li>Las reservas aprobadas aparecen en el <strong>calendario público</strong></li>
                        </ul>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3" style="font-size:0.95rem" id="submitBtn">
                        <i class="bi bi-send-fill me-2"></i> Enviar Solicitud
                    </button>
                    <a href="/reservas" class="btn btn-outline-secondary w-100 mt-2">
                        <i class="bi bi-x-lg me-1"></i> Cancelar
                    </a>
                </div>
            </div>
        </div>

    </div>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reservaForm');
    const labSelect = document.getElementById('id_laboratorio');
    const fechaInput = document.getElementById('fecha');
    const horaInicio = document.getElementById('hora_inicio');
    const horaFin = document.getElementById('hora_fin');
    const contenido = document.getElementById('contenido');

    // ── Flatpickr: Date Picker (full calendar) ──
    const fpFecha = flatpickr('#fecha', {
        locale: 'es',
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'l, j \d\e F Y',
        minDate: 'today',
        disable: [
            function(date) { return date.getDay() === 0 || date.getDay() === 6; }
        ],
        disableMobile: true,
        animate: true,
        onChange: function() { updateSummary(); }
    });

    // ── Flatpickr: Time Pickers (12h AM/PM) ──
    const fpHoraInicio = flatpickr('#hora_inicio', {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'H:i',
        altInput: true,
        altFormat: 'h:i K',
        time_24hr: false,
        minTime: '07:00',
        maxTime: '15:45',
        minuteIncrement: 15,
        disableMobile: true,
        onChange: function(selectedDates, dateStr) {
            if (dateStr && !horaFin.value) {
                const [h, m] = dateStr.split(':').map(Number);
                const endH = Math.min(h + 1, 16);
                const endTime = String(endH).padStart(2, '0') + ':' + String(m).padStart(2, '0');
                fpHoraFin.setDate(endTime, true);
            }
            updateSummary();
        }
    });

    const fpHoraFin = flatpickr('#hora_fin', {
        enableTime: true,
        noCalendar: true,
        dateFormat: 'H:i',
        altInput: true,
        altFormat: 'h:i K',
        time_24hr: false,
        minTime: '07:15',
        maxTime: '16:00',
        minuteIncrement: 15,
        disableMobile: true,
        onChange: function() { updateSummary(); }
    });

    // ── Live Summary ──
    function updateSummary() {
        const labOpt = labSelect.options[labSelect.selectedIndex];
        document.getElementById('summaryLab').textContent = (labOpt && labOpt.value) ? labOpt.text : '—';

        const fpAlt = document.querySelector('#fecha + input.flatpickr-input') || fechaInput;
        document.getElementById('summaryFecha').textContent = fechaInput.value ? (fpAlt.value || fechaInput.value) : '—';

        // Show AM/PM format in summary
        const altInicio = document.querySelector('#hora_inicio ~ input.flatpickr-input');
        const altFin = document.querySelector('#hora_fin ~ input.flatpickr-input');
        const sInicio = altInicio ? altInicio.value : horaInicio.value;
        const sFin = altFin ? altFin.value : horaFin.value;
        document.getElementById('summaryHorario').textContent =
            (horaInicio.value && horaFin.value) ? sInicio + ' — ' + sFin : '—';

        const txt = contenido.value.trim();
        document.getElementById('summaryContenido').textContent =
            txt ? (txt.length > 50 ? txt.substring(0, 50) + '…' : txt) : '—';

        // Group info
        const sem = document.getElementById('semestre');
        const car = document.getElementById('carrera');
        const alu = document.getElementById('total_alumnos');
        const parts = [];
        if (sem.value) parts.push(sem.value + '° Sem');
        if (car.value) parts.push(car.options[car.selectedIndex].text);
        if (alu.value) parts.push(alu.value + ' alumnos');
        document.getElementById('summaryGrupo').textContent = parts.length ? parts.join(' · ') : '—';
    }

    labSelect.addEventListener('change', updateSummary);
    contenido.addEventListener('input', updateSummary);
    document.getElementById('semestre').addEventListener('change', updateSummary);
    document.getElementById('carrera').addEventListener('change', updateSummary);
    document.getElementById('total_alumnos').addEventListener('input', updateSummary);
    updateSummary();

    // ── Character Counter ──
    contenido.addEventListener('input', function() {
        document.getElementById('contenidoCount').textContent = this.value.length + ' caracteres';
    });

    // ── Form Validation (in-app toasts) ──
    form.addEventListener('submit', function(e) {
        if (!fechaInput.value) {
            e.preventDefault();
            LabToast.warning('Por favor selecciona una fecha para la reserva.');
            return;
        }
        if (!horaInicio.value || !horaFin.value) {
            e.preventDefault();
            LabToast.warning('Por favor selecciona la hora de inicio y fin.');
            return;
        }
        if (horaInicio.value < '07:00' || horaFin.value > '16:00') {
            e.preventDefault();
            LabToast.error('El horario permitido es de 7:00 AM a 4:00 PM.');
            return;
        }
        if (horaFin.value <= horaInicio.value) {
            e.preventDefault();
            LabToast.error('La hora de fin debe ser posterior a la hora de inicio.');
            return;
        }
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('submitBtn').innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Enviando...';
        LabToast.info('Enviando solicitud...');
    });

    // ── Suggestion Slots ──
    document.querySelectorAll('.suggestion-slot').forEach(el => {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            fpHoraInicio.setDate(this.dataset.horaInicio, true);
            fpHoraFin.setDate(this.dataset.horaFin, true);
            if (this.dataset.fecha) fpFecha.setDate(this.dataset.fecha, true);
            updateSummary();
            form.scrollIntoView({ behavior: 'smooth', block: 'start' });

            [horaInicio, horaFin].forEach(inp => {
                inp.style.borderColor = '#1a7a4c';
                inp.style.boxShadow = '0 0 0 3px rgba(26,122,76,0.15)';
                setTimeout(() => { inp.style.borderColor = ''; inp.style.boxShadow = ''; }, 2000);
            });
            document.querySelectorAll('.suggestion-slot').forEach(s => s.style.background = '#fff');
            this.style.background = '#f0fdf4';
        });
    });

    // ── Suggestion Days ──
    document.querySelectorAll('.suggestion-day').forEach(el => {
        el.addEventListener('click', function(e) {
            e.preventDefault();
            fpFecha.setDate(this.dataset.fecha, true);
            updateSummary();
            form.scrollIntoView({ behavior: 'smooth', block: 'start' });

            fechaInput.style.borderColor = '#2e6da4';
            fechaInput.style.boxShadow = '0 0 0 3px rgba(46,109,164,0.15)';
            setTimeout(() => { fechaInput.style.borderColor = ''; fechaInput.style.boxShadow = ''; }, 2000);
            document.querySelectorAll('.suggestion-day').forEach(s => s.style.background = '#fff');
            this.style.background = '#eff6ff';
        });
    });
});
</script>
<?= $this->endSection() ?>
