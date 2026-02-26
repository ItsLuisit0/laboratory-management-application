<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 fade-in-up">
    <div>
        <h2 class="fw-bold mb-1">Calendario</h2>
        <p class="text-muted mb-0" style="font-size:0.88rem">Reservas aprobadas de todos los laboratorios</p>
    </div>
    <?php if (strtoupper($user['rol_nombre'] ?? '') === 'MAESTRO'): ?>
    <a href="/reservas/crear" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Nueva Solicitud
    </a>
    <?php endif; ?>
</div>

<div class="card shadow-sm fade-in-up">
    <div class="card-body" style="padding:24px">
        <div id="calendar"></div>
    </div>
</div>

<!-- Event Detail Modal -->
<div class="modal fade" id="eventModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:20px;border:none;box-shadow:0 25px 50px rgba(0,0,0,0.2);overflow:hidden">
            <div class="modal-header" style="background:linear-gradient(135deg,#115c38,#1a7a4c);color:#fff;border:none;padding:18px 24px">
                <h5 class="modal-title" id="eventModalTitle">
                    <i class="bi bi-building-fill me-2"></i>Reserva
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:brightness(0) invert(1)"></button>
            </div>
            <div class="modal-body" id="eventModalBody" style="padding:24px"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: '/calendario/eventos',
        eventClick: function(info) {
            const props = info.event.extendedProps;
            const start = info.event.start;
            const end = info.event.end;
            const startTime = start ? start.toLocaleTimeString('es-MX', {hour:'2-digit', minute:'2-digit'}) : '';
            const endTime = end ? end.toLocaleTimeString('es-MX', {hour:'2-digit', minute:'2-digit'}) : '';
            const dateStr = start ? start.toLocaleDateString('es-MX', {weekday:'long', year:'numeric', month:'long', day:'numeric'}) : '';

            document.getElementById('eventModalTitle').innerHTML = `<i class="bi bi-building-fill me-2"></i>${props.laboratorio || 'Reserva'}`;
            document.getElementById('eventModalBody').innerHTML = `
                <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #f1f5f9">
                    <span style="color:#64748b;font-weight:600;font-size:0.85rem"><i class="bi bi-building me-2"></i>Laboratorio</span>
                    <span style="font-weight:500">${props.laboratorio || '-'}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #f1f5f9">
                    <span style="color:#64748b;font-weight:600;font-size:0.85rem"><i class="bi bi-person me-2"></i>Docente</span>
                    <span style="font-weight:500">${props.usuario || '-'}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #f1f5f9">
                    <span style="color:#64748b;font-weight:600;font-size:0.85rem"><i class="bi bi-calendar me-2"></i>Fecha</span>
                    <span style="font-weight:500">${dateStr}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:10px 0">
                    <span style="color:#64748b;font-weight:600;font-size:0.85rem"><i class="bi bi-clock me-2"></i>Horario</span>
                    <span style="font-weight:500">${startTime} — ${endTime}</span>
                </div>
                ${props.carrera ? `<div style="display:flex;justify-content:space-between;padding:10px 0;border-top:1px solid #f1f5f9">
                    <span style="color:#64748b;font-weight:600;font-size:0.85rem"><i class="bi bi-book me-2"></i>Carrera</span>
                    <span style="font-weight:500">${props.carrera}</span>
                </div>` : ''}
                ${props.semestre ? `<div style="display:flex;justify-content:space-between;padding:10px 0;border-top:1px solid #f1f5f9">
                    <span style="color:#64748b;font-weight:600;font-size:0.85rem"><i class="bi bi-mortarboard me-2"></i>Semestre</span>
                    <span style="font-weight:500">${props.semestre}°</span>
                </div>` : ''}
                ${props.total_alumnos ? `<div style="display:flex;justify-content:space-between;padding:10px 0;border-top:1px solid #f1f5f9">
                    <span style="color:#64748b;font-weight:600;font-size:0.85rem"><i class="bi bi-people me-2"></i>Alumnos</span>
                    <span style="font-weight:500">${props.total_alumnos}</span>
                </div>` : ''}
            `;
            new bootstrap.Modal(document.getElementById('eventModal')).show();
        },
        height: 'auto',
        navLinks: true,
        editable: false,
        dayMaxEvents: 3,
        firstDay: 1,
        businessHours: { daysOfWeek: [1,2,3,4,5], startTime: '07:00', endTime: '16:00' },
        moreLinkText: 'más',
    });
    calendar.render();
});
</script>
<?= $this->endSection() ?>
