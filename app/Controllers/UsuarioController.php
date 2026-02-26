<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\RolModel;

class UsuarioController extends BaseController
{
    protected $usuarioModel;
    protected $rolModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->rolModel     = new RolModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Gestión de Usuarios',
            'usuarios' => $this->usuarioModel->getUsuariosConRol(),
            'user'     => session()->get('user'),
        ];
        return view('usuarios/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Crear Usuario',
            'roles' => $this->rolModel->getRolesDropdown(),
            'user'  => session()->get('user'),
        ];
        return view('usuarios/form', $data);
    }

    public function store()
    {
        $correo = $this->request->getPost('correo');

        if ($this->usuarioModel->emailExists($correo)) {
            return redirect()->back()
                           ->with('error', 'El correo ya está registrado.')
                           ->withInput();
        }

        $datos = [
            'nombre'   => $this->request->getPost('nombre'),
            'correo'   => $correo,
            'password' => $this->request->getPost('password'),
            'id_rol'   => $this->request->getPost('id_rol'),
            'estado'   => $this->request->getPost('estado') ?? 'ACTIVO',
        ];

        if ($this->usuarioModel->insert($datos)) {
            return redirect()->to('/usuarios')->with('success', 'Usuario creado exitosamente.');
        }

        return redirect()->back()
                       ->with('error', 'Error al crear el usuario.')
                       ->with('errors', $this->usuarioModel->errors())
                       ->withInput();
    }

    public function edit($id)
    {
        $usuario = $this->usuarioModel->find($id);
        if (!$usuario) {
            return redirect()->to('/usuarios')->with('error', 'Usuario no encontrado.');
        }

        $data = [
            'title'   => 'Editar Usuario',
            'usuario' => $usuario,
            'roles'   => $this->rolModel->getRolesDropdown(),
            'user'    => session()->get('user'),
        ];
        return view('usuarios/form', $data);
    }

    public function update($id)
    {
        $usuario = $this->usuarioModel->find($id);
        if (!$usuario) {
            return redirect()->to('/usuarios')->with('error', 'Usuario no encontrado.');
        }

        $correo = $this->request->getPost('correo');
        if ($this->usuarioModel->emailExists($correo, $id)) {
            return redirect()->back()
                           ->with('error', 'El correo ya está en uso por otro usuario.')
                           ->withInput();
        }

        $datos = [
            'nombre' => $this->request->getPost('nombre'),
            'correo' => $correo,
            'id_rol' => $this->request->getPost('id_rol'),
            'estado' => $this->request->getPost('estado') ?? 'ACTIVO',
        ];

        // Only update password if provided
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $datos['password'] = hash('sha256', $password);
        }

        $this->usuarioModel->setValidationRules([
            'nombre' => 'required|min_length[2]|max_length[100]',
            'correo' => 'required|valid_email|max_length[100]',
            'id_rol' => 'required|integer',
        ]);

        if ($this->usuarioModel->update($id, $datos)) {
            return redirect()->to('/usuarios')->with('success', 'Usuario actualizado exitosamente.');
        }

        return redirect()->back()
                       ->with('error', 'Error al actualizar el usuario.')
                       ->with('errors', $this->usuarioModel->errors())
                       ->withInput();
    }

    public function delete($id)
    {
        $currentUser = session()->get('user');
        if ($currentUser['id'] == $id) {
            return redirect()->to('/usuarios')->with('error', 'No puede eliminar su propia cuenta.');
        }

        if ($this->usuarioModel->delete($id)) {
            return redirect()->to('/usuarios')->with('success', 'Usuario eliminado exitosamente.');
        }

        return redirect()->to('/usuarios')->with('error', 'Error al eliminar el usuario.');
    }
}
