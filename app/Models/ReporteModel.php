<?php

namespace App\Models;

use CodeIgniter\Model;

class ReporteModel extends Model
{
    protected $table            = 'reportes_generados';
    protected $primaryKey       = 'id_reporte';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'tipo_reporte', 'generado_por', 'parametros'
    ];
    protected $useTimestamps    = false;

    /**
     * Log a generated report
     */
    public function registrarReporte(int $usuarioId, string $tipo, array $filtros): int
    {
        $this->insert([
            'tipo_reporte'    => $tipo,
            'generado_por'    => $usuarioId,
            'parametros'      => json_encode($filtros),
        ]);
        return $this->getInsertID();
    }

    /**
     * Get reports with user info
     */
    public function getReportesConUsuario(): array
    {
        return $this->select('reportes_generados.*, usuarios.nombre as usuario_nombre')
                    ->join('usuarios', 'usuarios.id_usuario = reportes_generados.generado_por')
                    ->orderBy('reportes_generados.fecha_generacion', 'DESC')
                    ->findAll();
    }
}
