<?php

namespace App\Models;

use CodeIgniter\Model;

class HorarioBloqueadoModel extends Model
{
    protected $table            = 'horarios_bloqueados';
    protected $primaryKey       = 'id_bloqueo';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'id_laboratorio', 'fecha', 'hora_inicio', 'hora_fin', 'motivo'
    ];
    protected $useTimestamps    = false;

    /**
     * Check if a time slot is blocked
     */
    public function estaBloqueado(int $laboratorioId, string $fecha, string $horaInicio, string $horaFin): bool
    {
        return $this->where('id_laboratorio', $laboratorioId)
                    ->where('fecha', $fecha)
                    ->groupStart()
                        ->where('hora_inicio <', $horaFin)
                        ->where('hora_fin >', $horaInicio)
                    ->groupEnd()
                    ->countAllResults() > 0;
    }

    /**
     * Get blocked hours with lab info
     */
    public function getBloqueoConLab(): array
    {
        return $this->select('horarios_bloqueados.*, laboratorios.nombre as laboratorio_nombre')
                    ->join('laboratorios', 'laboratorios.id_laboratorio = horarios_bloqueados.id_laboratorio')
                    ->orderBy('horarios_bloqueados.fecha', 'DESC')
                    ->findAll();
    }
}
