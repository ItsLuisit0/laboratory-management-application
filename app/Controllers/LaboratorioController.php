<?php

namespace App\Controllers;

use App\Models\LaboratorioModel;

class LaboratorioController extends BaseController
{
    protected $laboratorioModel;

    public function __construct()
    {
        $this->laboratorioModel = new LaboratorioModel();
    }

    public function index()
    {
        $data = [
            'title'        => 'Gestión de Laboratorios',
            'laboratorios' => $this->laboratorioModel->orderBy('nombre', 'ASC')->findAll(),
            'user'         => session()->get('user'),
        ];
        return view('laboratorios/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Crear Laboratorio',
            'user'  => session()->get('user'),
        ];
        return view('laboratorios/form', $data);
    }

    public function store()
    {
        $datos = [
            'nombre'      => $this->request->getPost('nombre'),
            'ubicacion'   => $this->request->getPost('ubicacion'),
            'capacidad'   => $this->request->getPost('capacidad'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => $this->request->getPost('estado') ?? 'DISPONIBLE',
        ];

        if ($this->laboratorioModel->insert($datos)) {
            return redirect()->to('/laboratorios')->with('success', 'Laboratorio creado exitosamente.');
        }

        return redirect()->back()
                       ->with('error', 'Error al crear el laboratorio.')
                       ->with('errors', $this->laboratorioModel->errors())
                       ->withInput();
    }

    public function edit($id)
    {
        $laboratorio = $this->laboratorioModel->find($id);
        if (!$laboratorio) {
            return redirect()->to('/laboratorios')->with('error', 'Laboratorio no encontrado.');
        }

        $data = [
            'title'       => 'Editar Laboratorio',
            'laboratorio' => $laboratorio,
            'user'        => session()->get('user'),
        ];
        return view('laboratorios/form', $data);
    }

    public function update($id)
    {
        $laboratorio = $this->laboratorioModel->find($id);
        if (!$laboratorio) {
            return redirect()->to('/laboratorios')->with('error', 'Laboratorio no encontrado.');
        }

        $datos = [
            'nombre'      => $this->request->getPost('nombre'),
            'ubicacion'   => $this->request->getPost('ubicacion'),
            'capacidad'   => $this->request->getPost('capacidad'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado'      => $this->request->getPost('estado') ?? 'DISPONIBLE',
        ];

        if ($this->laboratorioModel->update($id, $datos)) {
            return redirect()->to('/laboratorios')->with('success', 'Laboratorio actualizado exitosamente.');
        }

        return redirect()->back()
                       ->with('error', 'Error al actualizar el laboratorio.')
                       ->with('errors', $this->laboratorioModel->errors())
                       ->withInput();
    }

    public function delete($id)
    {
        if ($this->laboratorioModel->delete($id)) {
            return redirect()->to('/laboratorios')->with('success', 'Laboratorio eliminado exitosamente.');
        }

        return redirect()->to('/laboratorios')->with('error', 'Error al eliminar el laboratorio.');
    }
}
