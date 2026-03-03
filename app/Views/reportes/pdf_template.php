<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Reservas — LabControl</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; color: #333; }
        
        /* ── Colores Institucionales TECNM ── */
        .color-guinda { color: #6d112d; }
        .color-verde { color: #0d4a2b; }
        .bg-guinda { background-color: #6d112d; color: white; }
        .bg-verde { background-color: #0d4a2b; color: white; }

        /* ── Header ── */
        .header { background: #6d112d; color: white; padding: 25px 35px; border-bottom: 5px solid #0d4a2b; }
        .header table { width: 100%; border: none; margin: 0; padding: 0; }
        .header td { padding: 0; border: none; background: transparent; }
        .header-title { font-size: 24px; font-weight: bold; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 1px; }
        .header-subtitle { font-size: 14px; font-weight: 300; opacity: 0.9; }
        .header-meta { text-align: right; font-size: 10px; opacity: 0.8; }
        
        /* ── Contenido ── */
        .content { padding: 30px 35px; }
        
        /* ── Filtros ── */
        .filters { background: #f8f9fa; padding: 12px 18px; border-left: 4px solid #6d112d; margin-bottom: 25px; font-size: 10px; }
        .filters strong { color: #6d112d; }
        
        /* ── Resumen ── */
        .summary-container { width: 100%; margin-bottom: 25px; border-collapse: collapse; }
        .summary-container td { padding: 10px; width: 25%; text-align: center; }
        .summary-box { background: #f1f5f9; padding: 10px; text-align: center; }
        .summary-box.total { border-top: 2px solid #0d4a2b; }
        .summary-box.aprobadas { border-top: 2px solid #198754; }
        .summary-box.pendientes { border-top: 2px solid #ffca2c; }
        .summary-box.rechazadas { border-top: 2px solid #dc3545; }
        .summary-title { font-size: 10px; text-transform: uppercase; color: #64748b; font-weight: bold; margin-bottom: 5px; }
        .summary-value { font-size: 16px; font-weight: bold; color: #1e293b; }

        /* ── Tabla Principal ── */
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 10px; }
        table.data-table thead th { background: #0d4a2b; color: white; padding: 8px 10px; text-align: left; text-transform: uppercase; font-size: 9px; border-bottom: 2px solid #0a3a22; }
        table.data-table tbody td { padding: 8px 10px; border-bottom: 1px solid #edf2f7; color: #334155; vertical-align: middle; }
        table.data-table tbody tr:nth-child(even) { background: #f8fafc; }
        
        /* ── Estado Badges ── */
        .badge { display: inline-block; padding: 3px 8px; font-size: 9px; font-weight: bold; color: white; text-transform: uppercase; }
        .badge-APROBADA { background: #198754; }
        .badge-PENDIENTE { background: #ffc107; color: #000; }
        .badge-RECHAZADA { background: #dc3545; }
        .badge-CANCELADA { background: #6c757d; }
        
        /* ── Footer ── */
        .footer { width: 100%; text-align: center; margin-top: 40px; padding-top: 15px; border-top: 1px solid #cbd5e1; font-size: 9px; color: #64748b; }
        .footer-logo { font-weight: bold; color: #6d112d; font-size: 10px; margin-bottom: 4px; }
    </style>
</head>
<body>
    <div class="header">
        <table>
            <tr>
                <td style="width: 60%;">
                    <div class="header-title">Reporte de Laboratorios</div>
                    <div class="header-subtitle">Instituto Tecnológico Superior de Teziutlán</div>
                </td>
                <td style="width: 40%;" class="header-meta">
                    <p>Fecha de emisión: <strong><?= esc($fecha_reporte) ?></strong></p>
                    <p>Generado por: <strong><?= esc($generado_por) ?></strong></p>
                </td>
            </tr>
        </table>
    </div>

    <div class="content">
        <?php if (!empty($filters)): ?>
        <div class="filters">
            <strong>Filtros aplicados:</strong>
            <?php foreach ($filters as $key => $value): ?>
                <span><?= ucfirst(str_replace('_', ' ', $key)) ?>: <strong><?= esc($value) ?></strong></span> &nbsp;|&nbsp;
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php
            $aprobadas = count(array_filter($reservas, fn($r) => $r['estado'] === 'APROBADA'));
            $pendientes = count(array_filter($reservas, fn($r) => $r['estado'] === 'PENDIENTE'));
            $rechazadas = count(array_filter($reservas, fn($r) => $r['estado'] === 'RECHAZADA'));
        ?>
        <table class="summary-container">
            <tr>
                <td>
                    <div class="summary-box total">
                        <div class="summary-title">Total Reservas</div>
                        <div class="summary-value"><?= count($reservas) ?></div>
                    </div>
                </td>
                <td>
                    <div class="summary-box aprobadas">
                        <div class="summary-title">Aprobadas</div>
                        <div class="summary-value color-verde"><?= $aprobadas ?></div>
                    </div>
                </td>
                <td>
                    <div class="summary-box pendientes">
                        <div class="summary-title">Pendientes</div>
                        <div class="summary-value" style="color: #b78a00;"><?= $pendientes ?></div>
                    </div>
                </td>
                <td>
                    <div class="summary-box rechazadas">
                        <div class="summary-title">Rechazadas</div>
                        <div class="summary-value" style="color: #dc3545;"><?= $rechazadas ?></div>
                    </div>
                </td>
            </tr>
        </table>

        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Laboratorio</th>
                    <th>Solicitante</th>
                    <th>Fecha</th>
                    <th>Horario</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($reservas)): ?>
                    <?php foreach ($reservas as $i => $r): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($r['laboratorio_nombre']) ?></td>
                        <td><?= esc($r['usuario_nombre']) ?></td>
                        <td><?= esc($r['fecha']) ?></td>
                        <td><?= esc($r['hora_inicio']) ?> - <?= esc($r['hora_fin']) ?></td>
                        <td>
                            <span class="badge badge-<?= esc($r['estado']) ?>">
                                <?= esc($r['estado']) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center; padding: 20px; color: #999;">No se encontraron reservas con los filtros aplicados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <div class="footer-logo">TECNM Campus Teziutlán — LabControl</div>
        <p>Documento de control académico generado automáticamente. No requiere firma autógrafa.</p>
        <p style="margin-top: 4px; opacity: 0.7;">&copy; <?= date('Y') ?> Instituto Tecnológico Superior de Teziutlán</p>
    </div>
</body>
</html>
