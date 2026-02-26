<?php

namespace App\Controllers;

use App\Models\ReservaModel;
use App\Models\LaboratorioModel;
use App\Models\UsuarioModel;
use App\Models\PracticaModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $user = session()->get('user');
        $reservaModel     = new ReservaModel();
        $laboratorioModel = new LaboratorioModel();
        $usuarioModel     = new UsuarioModel();
        $practicaModel    = new PracticaModel();

        $data = [
            'title'             => 'Dashboard',
            'user'              => $user,
            'total_pendientes'  => count($reservaModel->getPendientes()),
            'total_reservas'    => $reservaModel->countAllResults(),
            'total_laboratorios'=> $laboratorioModel->countAllResults(),
            'total_usuarios'    => $usuarioModel->countAllResults(),
            'total_practicas'   => $practicaModel->countAllResults(),
            'reservas_recientes'=> $reservaModel->getReservasCompletas([
                'fecha_inicio' => date('Y-m-d', strtotime('-7 days')),
            ]),
            'reservas_hoy'      => $reservaModel->getReservasCompletas([
                'fecha_inicio' => date('Y-m-d'),
                'fecha_fin'    => date('Y-m-d'),
            ]),
        ];

        return view('dashboard/index', $data);
    }
}
