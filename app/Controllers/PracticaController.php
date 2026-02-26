<?php

namespace App\Controllers;

use App\Models\PracticaModel;
use App\Models\ReservaModel;

class PracticaController extends BaseController
{
    protected $practicaModel;
    protected $reservaModel;

    public function __construct()
    {
        $this->practicaModel = new PracticaModel();
        $this->reservaModel  = new ReservaModel();
    }

    public function index()
    {
        $user = session()->get('user');
        $filters = [];

        if (strtoupper($user['rol_nombre']) === 'MAESTRO') {
            $filters['id_maestro'] = $user['id'];
        }

        $data = [
            'title'     => 'Prácticas',
            'practicas' => $this->practicaModel->getPracticasCompletas($filters),
            'user'      => $user,
        ];
        return view('practicas/index', $data);
    }

    public function create($reservaId)
    {
        $reserva = $this->reservaModel->find($reservaId);
        if (!$reserva) {
            return redirect()->to('/practicas')->with('error', 'Reserva no encontrada.');
        }

        $existing = $this->practicaModel->getByReserva($reservaId);
        if ($existing) {
            return redirect()->to('/practicas/editar/' . $existing['id_practica'])
                           ->with('info', 'Ya existe una práctica para esta reserva. Puede editarla.');
        }

        $data = [
            'title'   => 'Registrar Práctica',
            'reserva' => $reserva,
            'user'    => session()->get('user'),
        ];
        return view('practicas/form', $data);
    }

    public function store()
    {
        $datos = [
            'id_reserva'     => $this->request->getPost('id_reserva'),
            'contenido'      => $this->request->getPost('contenido'),
            'requerimientos' => $this->request->getPost('requerimientos'),
        ];

        if ($this->practicaModel->insert($datos)) {
            return redirect()->to('/practicas')->with('success', 'Práctica registrada exitosamente.');
        }

        return redirect()->back()
                       ->with('error', 'Error al registrar la práctica.')
                       ->with('errors', $this->practicaModel->errors())
                       ->withInput();
    }

    public function edit($id)
    {
        $practica = $this->practicaModel->find($id);
        if (!$practica) {
            return redirect()->to('/practicas')->with('error', 'Práctica no encontrada.');
        }

        $reserva = $this->reservaModel->find($practica['id_reserva']);

        $data = [
            'title'    => 'Editar Práctica',
            'practica' => $practica,
            'reserva'  => $reserva,
            'user'     => session()->get('user'),
        ];
        return view('practicas/form', $data);
    }

    public function update($id)
    {
        $practica = $this->practicaModel->find($id);
        if (!$practica) {
            return redirect()->to('/practicas')->with('error', 'Práctica no encontrada.');
        }

        $datos = [
            'contenido'      => $this->request->getPost('contenido'),
            'requerimientos' => $this->request->getPost('requerimientos'),
        ];

        if ($this->practicaModel->update($id, $datos)) {
            return redirect()->to('/practicas')->with('success', 'Práctica actualizada exitosamente.');
        }

        return redirect()->back()
                       ->with('error', 'Error al actualizar la práctica.')
                       ->with('errors', $this->practicaModel->errors())
                       ->withInput();
    }
}
