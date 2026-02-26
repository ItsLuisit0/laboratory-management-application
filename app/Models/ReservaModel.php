<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservaModel extends Model
{
    protected $table            = 'reservas';
    protected $primaryKey       = 'id_reserva';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'id_laboratorio', 'id_maestro', 'fecha', 'hora_inicio',
        'hora_fin', 'semestre', 'carrera', 'total_alumnos',
        'estado', 'aprobado_por', 'fecha_aprobacion'
    ];
    protected $useTimestamps    = false;

    protected $validationRules = [
        'id_laboratorio' => 'required|integer',
        'id_maestro'     => 'required|integer',
        'fecha'          => 'required|valid_date',
        'hora_inicio'    => 'required',
        'hora_fin'       => 'required',
    ];

    /**
     * Check for scheduling conflicts
     */
    public function existeConflicto(int $laboratorioId, string $fecha, string $horaInicio, string $horaFin, ?int $excludeId = null): bool
    {
        $builder = $this->where('id_laboratorio', $laboratorioId)
                        ->where('fecha', $fecha)
                        ->where('estado !=', 'RECHAZADA')
                        ->where('estado !=', 'CANCELADA')
                        ->groupStart()
                            ->where('hora_inicio <', $horaFin)
                            ->where('hora_fin >', $horaInicio)
                        ->groupEnd();

        if ($excludeId) {
            $builder->where('id_reserva !=', $excludeId);
        }

        return $builder->countAllResults() > 0;
    }

    /**
     * Get reservations with related data
     */
    public function getReservasCompletas(array $filters = []): array
    {
        $builder = $this->select('reservas.*, 
                        laboratorios.nombre as laboratorio_nombre,
                        u1.nombre as usuario_nombre,
                        u2.nombre as aprobador_nombre')
                        ->join('laboratorios', 'laboratorios.id_laboratorio = reservas.id_laboratorio')
                        ->join('usuarios u1', 'u1.id_usuario = reservas.id_maestro')
                        ->join('usuarios u2', 'u2.id_usuario = reservas.aprobado_por', 'left');

        if (!empty($filters['estado'])) {
            $builder->where('reservas.estado', $filters['estado']);
        }
        if (!empty($filters['id_laboratorio'])) {
            $builder->where('reservas.id_laboratorio', $filters['id_laboratorio']);
        }
        if (!empty($filters['id_maestro'])) {
            $builder->where('reservas.id_maestro', $filters['id_maestro']);
        }
        if (!empty($filters['fecha_inicio'])) {
            $builder->where('reservas.fecha >=', $filters['fecha_inicio']);
        }
        if (!empty($filters['fecha_fin'])) {
            $builder->where('reservas.fecha <=', $filters['fecha_fin']);
        }

        return $builder->orderBy('reservas.fecha', 'DESC')
                       ->orderBy('reservas.hora_inicio', 'ASC')
                       ->findAll();
    }

    /**
     * Get pending reservations
     */
    public function getPendientes(): array
    {
        return $this->getReservasCompletas(['estado' => 'PENDIENTE']);
    }

    /**
     * Auto-complete approved reservations whose date+time has passed.
     * Called automatically when loading calendar events.
     */
    public function completarReservasPasadas(): int
    {
        $now = date('Y-m-d H:i:s');
        $hoy = date('Y-m-d');
        $hora = date('H:i:s');

        // Past days
        $builder = $this->builder();
        $affected = $builder->where('estado', 'APROBADA')
                            ->where('fecha <', $hoy)
                            ->update(['estado' => 'COMPLETADA']);

        // Today but end time already passed
        $builder2 = $this->builder();
        $affected2 = $builder2->where('estado', 'APROBADA')
                              ->where('fecha', $hoy)
                              ->where('hora_fin <=', $hora)
                              ->update(['estado' => 'COMPLETADA']);

        // Also expire pending reservations from past days
        $builder3 = $this->builder();
        $builder3->where('estado', 'PENDIENTE')
                 ->where('fecha <', $hoy)
                 ->update(['estado' => 'CANCELADA']);

        return $this->db->affectedRows();
    }

    /**
     * Get reservations as calendar events
     * Automatically completes past reservations before building the list.
     */
    public function getEventosCalendario(array $filters = []): array
    {
        // Auto-complete past reservations
        $this->completarReservasPasadas();

        $reservas = $this->getReservasCompletas($filters);
        $eventos = [];

        $colores = [
            'PENDIENTE'  => '#f59e0b',
            'APROBADA'   => '#1a7a4c',
            'COMPLETADA' => '#6b7280',
            'RECHAZADA'  => '#ef4444',
            'CANCELADA'  => '#94a3b8',
        ];

        foreach ($reservas as $reserva) {
            // Skip completed, rejected, and cancelled — keep calendar clean
            if (in_array($reserva['estado'], ['COMPLETADA', 'RECHAZADA', 'CANCELADA'])) {
                continue;
            }

            $eventos[] = [
                'id'              => $reserva['id_reserva'],
                'title'           => $reserva['laboratorio_nombre'] . ' - ' . $reserva['usuario_nombre'],
                'start'           => $reserva['fecha'] . 'T' . $reserva['hora_inicio'],
                'end'             => $reserva['fecha'] . 'T' . $reserva['hora_fin'],
                'backgroundColor' => $colores[$reserva['estado']] ?? '#6b7280',
                'borderColor'     => $colores[$reserva['estado']] ?? '#6b7280',
                'extendedProps'   => [
                    'estado'        => $reserva['estado'],
                    'laboratorio'   => $reserva['laboratorio_nombre'],
                    'usuario'       => $reserva['usuario_nombre'],
                    'semestre'      => $reserva['semestre'] ?? '',
                    'carrera'       => $reserva['carrera'] ?? '',
                    'total_alumnos' => $reserva['total_alumnos'] ?? 0,
                ],
            ];
        }

        return $eventos;
    }

    /**
     * Approve a reservation
     */
    public function aprobar(int $id, int $aprobadoPor): bool
    {
        return $this->update($id, [
            'estado'           => 'APROBADA',
            'aprobado_por'     => $aprobadoPor,
            'fecha_aprobacion' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Reject a reservation
     */
    public function rechazar(int $id, int $aprobadoPor): bool
    {
        return $this->update($id, [
            'estado'           => 'RECHAZADA',
            'aprobado_por'     => $aprobadoPor,
            'fecha_aprobacion' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Get available time slots for a lab on a specific date
     */
    public function getHorariosDisponibles(int $laboratorioId, string $fecha, int $duracionMinutos = 60): array
    {
        // Get existing reservations for this lab on this date
        $reservas = $this->where('id_laboratorio', $laboratorioId)
                         ->where('fecha', $fecha)
                         ->where('estado !=', 'RECHAZADA')
                         ->where('estado !=', 'CANCELADA')
                         ->orderBy('hora_inicio', 'ASC')
                         ->findAll();

        // Lab hours: 7:00 AM to 4:00 PM
        $inicioLab = 7 * 60;  // minutes from midnight
        $finLab    = 16 * 60;

        // Build list of occupied ranges (in minutes)
        $ocupados = [];
        foreach ($reservas as $r) {
            $parts = explode(':', $r['hora_inicio']);
            $start = (int)$parts[0] * 60 + (int)$parts[1];
            $parts = explode(':', $r['hora_fin']);
            $end   = (int)$parts[0] * 60 + (int)$parts[1];
            $ocupados[] = ['inicio' => $start, 'fin' => $end];
        }

        // Find free slots
        $disponibles = [];
        $cursor = $inicioLab;

        while ($cursor + $duracionMinutos <= $finLab) {
            $slotFin = $cursor + $duracionMinutos;
            $libre = true;

            foreach ($ocupados as $o) {
                if ($cursor < $o['fin'] && $slotFin > $o['inicio']) {
                    $libre = false;
                    // Jump cursor past this occupied block
                    $cursor = $o['fin'];
                    break;
                }
            }

            if ($libre) {
                $disponibles[] = [
                    'hora_inicio' => sprintf('%02d:%02d', intdiv($cursor, 60), $cursor % 60),
                    'hora_fin'    => sprintf('%02d:%02d', intdiv($slotFin, 60), $slotFin % 60),
                ];
                $cursor = $slotFin;
            }

            if (count($disponibles) >= 5) break; // Max 5 suggestions
        }

        return $disponibles;
    }

    /**
     * Get nearby available days for a lab (next 14 days)
     */
    public function getDiasDisponibles(int $laboratorioId, string $fechaOriginal): array
    {
        $diasDisponibles = [];

        for ($i = 0; $i <= 14; $i++) {
            $fecha = date('Y-m-d', strtotime($fechaOriginal . " +{$i} days"));

            // Skip weekends (Saturday=6, Sunday=0)
            $diaSemana = date('w', strtotime($fecha));
            if ($diaSemana == 0 || $diaSemana == 6) continue;

            // Skip if it's the same original date
            if ($fecha === $fechaOriginal) continue;

            // Count reservations for this day
            $count = $this->where('id_laboratorio', $laboratorioId)
                          ->where('fecha', $fecha)
                          ->where('estado !=', 'RECHAZADA')
                          ->where('estado !=', 'CANCELADA')
                          ->countAllResults();

            // Max ~14 slots per day (7AM-9PM), show days with availability
            if ($count < 10) {
                $diasDisponibles[] = [
                    'fecha'            => $fecha,
                    'dia_nombre'       => $this->getNombreDia($fecha),
                    'reservas_activas' => $count,
                ];
            }

            if (count($diasDisponibles) >= 5) break;
        }

        return $diasDisponibles;
    }

    /**
     * Get Spanish day name
     */
    private function getNombreDia(string $fecha): string
    {
        $dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        return $dias[(int)date('w', strtotime($fecha))] . ' ' . date('d/m/Y', strtotime($fecha));
    }
}
