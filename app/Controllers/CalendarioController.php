<?php

namespace App\Controllers;

use App\Models\ReservaModel;

class CalendarioController extends BaseController
{
    protected $reservaModel;

    public function __construct()
    {
        $this->reservaModel = new ReservaModel();
    }

    /**
     * Public calendar — no login required (for students / anyone)
     */
    public function publico()
    {
        return view('calendario/publico');
    }

    /**
     * Public events endpoint — only approved reservations
     */
    public function eventosPublicos()
    {
        $eventos = $this->reservaModel->getEventosCalendario(['estado' => 'APROBADA']);
        return $this->response->setJSON($eventos);
    }

    /**
     * Authenticated calendar (used inside dashboard for staff)
     */
    public function index()
    {
        $data = [
            'title' => 'Calendario de Reservas',
            'user'  => session()->get('user'),
        ];
        return view('calendario/index', $data);
    }

    /**
     * Authenticated events endpoint — shows all statuses for staff
     */
    public function eventos()
    {
        $user = session()->get('user');
        $filters = [];

        if (strtoupper($user['rol_nombre']) === 'MAESTRO') {
            $filters['id_maestro'] = $user['id'];
        }

        $eventos = $this->reservaModel->getEventosCalendario($filters);
        return $this->response->setJSON($eventos);
    }
}
