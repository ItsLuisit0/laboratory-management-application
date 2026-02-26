<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Reservas — LabControl</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Helvetica, Arial, sans-serif; font-size: 11px; color: #333; }
        .header { background: #1a237e; color: white; padding: 20px 30px; margin-bottom: 20px; }
        .header h1 { font-size: 22px; margin-bottom: 5px; }
        .header p { font-size: 11px; opacity: 0.9; }
        .content { padding: 0 30px; }
        .filters { background: #f5f5f5; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; font-size: 10px; }
        .filters strong { color: #1a237e; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        thead th { background: #1a237e; color: white; padding: 8px 10px; text-align: left; font-size: 10px; text-transform: uppercase; }
        tbody td { padding: 7px 10px; border-bottom: 1px solid #e0e0e0; font-size: 10px; }
        tbody tr:nth-child(even) { background: #f9f9f9; }
        .badge { display: inline-block; padding: 3px 8px; border-radius: 10px; font-size: 9px; font-weight: bold; color: white; }
        .badge-APROBADA { background: #28a745; }
        .badge-PENDIENTE { background: #ffc107; color: #333; }
        .badge-RECHAZADA { background: #dc3545; }
        .badge-CANCELADA { background: #6c757d; }
        .footer { text-align: center; margin-top: 30px; padding-top: 15px; border-top: 2px solid #1a237e; font-size: 9px; color: #666; }
        .summary { background: #e8eaf6; padding: 10px 15px; border-radius: 6px; margin-bottom: 20px; }
        .summary span { margin-right: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LabControl — Reporte de Reservas</h1>
        <p>Generado: <?= esc($fecha_reporte) ?> | Por: <?= esc($generado_por) ?></p>
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

        <div class="summary">
            <span>Total de reservas: <?= count($reservas) ?></span>
            <?php
                $aprobadas = count(array_filter($reservas, fn($r) => $r['estado'] === 'APROBADA'));
                $pendientes = count(array_filter($reservas, fn($r) => $r['estado'] === 'PENDIENTE'));
                $rechazadas = count(array_filter($reservas, fn($r) => $r['estado'] === 'RECHAZADA'));
            ?>
            <span>Aprobadas: <?= $aprobadas ?></span>
            <span>Pendientes: <?= $pendientes ?></span>
            <span>Rechazadas: <?= $rechazadas ?></span>
        </div>

        <table>
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
        <p>&copy; <?= date('Y') ?> LabControl — Sistema de Gestión de Laboratorios Académicos</p>
        <p>Documento generado automáticamente. No requiere firma.</p>
    </div>
</body>
</html>
