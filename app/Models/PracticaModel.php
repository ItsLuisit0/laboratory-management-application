<?php

namespace App\Models;

use CodeIgniter\Model;

class PracticaModel extends Model
{
    protected $table            = 'practicas';
    protected $primaryKey       = 'id_practica';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'id_reserva', 'contenido', 'requerimientos'
    ];
    protected $useTimestamps    = false;

    protected $validationRules = [
        'id_reserva'  => 'required|integer',
        'contenido'   => 'required|min_length[5]',
    ];

    /**
     * Get practices with reservation info
     */
    public function getPracticasCompletas(array $filters = []): array
    {
        $builder = $this->select('practicas.*, reservas.fecha, reservas.hora_inicio, reservas.hora_fin,
                        laboratorios.nombre as laboratorio_nombre,
                        usuarios.nombre as maestro_nombre')
                        ->join('reservas', 'reservas.id_reserva = practicas.id_reserva')
                        ->join('laboratorios', 'laboratorios.id_laboratorio = reservas.id_laboratorio')
                        ->join('usuarios', 'usuarios.id_usuario = reservas.id_maestro');

        if (!empty($filters['id_reserva'])) {
            $builder->where('practicas.id_reserva', $filters['id_reserva']);
        }
        if (!empty($filters['id_maestro'])) {
            $builder->where('reservas.id_maestro', $filters['id_maestro']);
        }

        return $builder->orderBy('reservas.fecha', 'DESC')->findAll();
    }

    /**
     * Get practice by reservation
     */
    public function getByReserva(int $reservaId): ?array
    {
        return $this->where('id_reserva', $reservaId)->first();
    }
}
