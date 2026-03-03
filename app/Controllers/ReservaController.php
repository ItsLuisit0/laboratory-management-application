<?php

namespace App\Controllers;

use App\Models\ReservaModel;
use App\Models\LaboratorioModel;
use App\Models\HorarioBloqueadoModel;

class ReservaController extends BaseController
{
    protected $reservaModel;
    protected $laboratorioModel;
    protected $horarioBloqueadoModel;

    public function __construct()
    {
        $this->reservaModel          = new ReservaModel();
        $this->laboratorioModel      = new LaboratorioModel();
        $this->horarioBloqueadoModel = new HorarioBloqueadoModel();
    }

    public function index()
    {
        $user = session()->get('user');
        $filters = [];

        if (strtoupper($user['rol_nombre']) === 'MAESTRO') {
            $filters['id_maestro'] = $user['id'];
        }

        if (strtoupper($user['rol_nombre']) === 'ALUMNO') {
            $filters['estado'] = 'APROBADA';
        }

        $data = [
            'title'    => 'Reservas',
            'reservas' => $this->reservaModel->getReservasCompletas($filters),
            'user'     => $user,
        ];
        return view('reservas/index', $data);
    }

    public function create()
    {
        $data = [
            'title'        => 'Solicitar Reserva',
            'laboratorios' => $this->laboratorioModel->getDropdown(),
            'user'         => session()->get('user'),
            'loadFlatpickr'=> true,
        ];
        return view('reservas/create', $data);
    }

    public function store()
    {
        $user = session()->get('user');

        $laboratorioId = (int)$this->request->getPost('id_laboratorio');
        $fecha         = $this->request->getPost('fecha');
        $horaInicio    = $this->request->getPost('hora_inicio');
        $horaFin       = $this->request->getPost('hora_fin');

        // Validate hora_fin > hora_inicio
        if ($horaFin <= $horaInicio) {
            return redirect()->back()
                           ->with('error', 'La hora de fin debe ser posterior a la hora de inicio.')
                           ->withInput();
        }

        // Validate allowed hours: 7:00 AM — 4:00 PM
        if ($horaInicio < '07:00' || $horaFin > '16:00') {
            return redirect()->back()
                           ->with('error', 'El horario de reserva permitido es de 7:00 AM a 4:00 PM.')
                           ->withInput();
        }

        // Check blocked schedule
        if ($this->horarioBloqueadoModel->estaBloqueado($laboratorioId, $fecha, $horaInicio, $horaFin)) {
            return redirect()->back()
                           ->with('error', 'El horario seleccionado se encuentra bloqueado para este laboratorio.')
                           ->withInput();
        }

        // Check for conflicts — if conflict, show suggestions
        if ($this->reservaModel->existeConflicto($laboratorioId, $fecha, $horaInicio, $horaFin)) {
            // Calculate requested duration in minutes
            $partsInicio = explode(':', $horaInicio);
            $partsFin    = explode(':', $horaFin);
            $duracion    = ((int)$partsFin[0] * 60 + (int)$partsFin[1]) - ((int)$partsInicio[0] * 60 + (int)$partsInicio[1]);

            // Get suggestions
            $horariosDisponibles = $this->reservaModel->getHorariosDisponibles($laboratorioId, $fecha, $duracion);
            $diasDisponibles     = $this->reservaModel->getDiasDisponibles($laboratorioId, $fecha);

            $lab = $this->laboratorioModel->find($laboratorioId);

            $data = [
                'title'                => 'Solicitar Reserva',
                'laboratorios'         => $this->laboratorioModel->getDropdown(),
                'user'                 => $user,
                'conflicto'            => true,
                'lab_conflicto'        => $lab['nombre'] ?? '',
                'fecha_conflicto'      => $fecha,
                'horarios_disponibles' => $horariosDisponibles,
                'dias_disponibles'     => $diasDisponibles,
                'loadFlatpickr'        => true,
            ];

            // Preserve old input
            session()->setFlashdata('_ci_old_input', [
                'post' => $this->request->getPost(),
            ]);

            return view('reservas/create', $data);
        }

        $datos = [
            'id_laboratorio' => $laboratorioId,
            'id_maestro'     => $user['id'],
            'fecha'          => $fecha,
            'hora_inicio'    => $horaInicio,
            'hora_fin'       => $horaFin,
            'semestre'       => $this->request->getPost('semestre'),
            'carrera'        => $this->request->getPost('carrera'),
            'total_alumnos'  => (int)$this->request->getPost('total_alumnos'),
            'estado'         => 'PENDIENTE',
        ];

        $reservaId = $this->reservaModel->insert($datos);

        if ($reservaId) {
            // Also create the linked practice
            $contenido      = $this->request->getPost('contenido');
            $requerimientos = $this->request->getPost('requerimientos');

            if (!empty($contenido)) {
                $practicaModel = new \App\Models\PracticaModel();
                $practicaModel->insert([
                    'id_reserva'     => $reservaId,
                    'contenido'      => $contenido,
                    'requerimientos' => $requerimientos ?? '',
                ]);
            }

            return redirect()->to('/reservas')->with('success', 'Solicitud de reserva creada exitosamente.');
        }

        return redirect()->back()
                       ->with('error', 'Error al crear la reserva.')
                       ->with('errors', $this->reservaModel->errors())
                       ->withInput();
    }

    public function pendientes()
    {
        $reservas = $this->reservaModel->getPendientes();

        // Load linked practice for each reservation
        $practicaModel = new \App\Models\PracticaModel();
        foreach ($reservas as &$r) {
            $practica = $practicaModel->where('id_reserva', $r['id_reserva'])->first();
            $r['contenido']      = $practica['contenido'] ?? '';
            $r['requerimientos'] = $practica['requerimientos'] ?? '';
        }

        $data = [
            'title'    => 'Solicitudes Pendientes',
            'reservas' => $reservas,
            'user'     => session()->get('user'),
        ];
        return view('reservas/pendientes', $data);
    }

    public function aprobar($id)
    {
        $user = session()->get('user');
        $reserva = $this->reservaModel->find($id);

        if (!$reserva) {
            return redirect()->to('/reservas/pendientes')->with('error', 'Reserva no encontrada.');
        }

        // Re-check for conflicts before approving
        if ($this->reservaModel->existeConflicto(
            $reserva['id_laboratorio'],
            $reserva['fecha'],
            $reserva['hora_inicio'],
            $reserva['hora_fin'],
            $id
        )) {
            return redirect()->to('/reservas/pendientes')
                           ->with('error', 'No se puede aprobar: existe conflicto de horario con otra reserva aprobada.');
        }

        $this->reservaModel->aprobar($id, $user['id']);
        return redirect()->to('/reservas/pendientes')->with('success', 'Reserva aprobada exitosamente.');
    }

    public function rechazar($id)
    {
        $user = session()->get('user');
        $reserva = $this->reservaModel->find($id);

        if (!$reserva) {
            return redirect()->to('/reservas/pendientes')->with('error', 'Reserva no encontrada.');
        }

        $this->reservaModel->rechazar($id, $user['id']);
        return redirect()->to('/reservas/pendientes')->with('success', 'Reserva rechazada.');
    }

    public function detalle($id)
    {
        $reservas = $this->reservaModel->getReservasCompletas();
        $reserva = null;
        foreach ($reservas as $r) {
            if ($r['id_reserva'] == $id) {
                $reserva = $r;
                break;
            }
        }

        if (!$reserva) {
            return redirect()->to('/reservas')->with('error', 'Reserva no encontrada.');
        }

        // Load linked practice
        $practicaModel = new \App\Models\PracticaModel();
        $practica = $practicaModel->getByReserva($id);

        $data = [
            'title'    => 'Detalle de Reserva',
            'reserva'  => $reserva,
            'practica' => $practica,
            'user'     => session()->get('user'),
        ];
        return view('reservas/detalle', $data);
    }
}
