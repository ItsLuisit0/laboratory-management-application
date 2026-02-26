<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\RolModel;

class AuthController extends BaseController
{
    protected $usuarioModel;
    protected $rolModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->rolModel     = new RolModel();
        helper('jwt');
    }

    public function login()
    {
        if (session()->get('jwt_token')) {
            return $this->redirectByRole();
        }
        return view('auth/login');
    }

    public function authenticate()
    {
        $correo   = $this->request->getPost('correo');
        $password = $this->request->getPost('password');

        if (empty($correo) || empty($password)) {
            return redirect()->to('/auth/login')
                           ->with('error', 'Correo y contraseña son requeridos.')
                           ->withInput();
        }

        $usuario = $this->usuarioModel->authenticate($correo, $password);

        if (!$usuario) {
            return redirect()->to('/auth/login')
                           ->with('error', 'Credenciales inválidas o cuenta desactivada.')
                           ->withInput();
        }

        // Get role info
        $rol = $this->rolModel->find($usuario['id_rol']);
        $usuario['rol_nombre'] = $rol ? $rol['nombre'] : 'MAESTRO';

        // Generate JWT
        $token = generateJWT($usuario);

        // Store in session
        $session = session();
        $session->set('jwt_token', $token);
        $session->set('user', [
            'id'         => $usuario['id_usuario'],
            'nombre'     => $usuario['nombre'],
            'correo'     => $usuario['correo'],
            'id_rol'     => $usuario['id_rol'],
            'rol_nombre' => $usuario['rol_nombre'],
        ]);

        return $this->redirectByRole($usuario['rol_nombre'], $usuario['nombre']);
    }

    /**
     * Redirect to the appropriate landing page based on role
     */
    private function redirectByRole(?string $rolNombre = null, ?string $nombre = null)
    {
        $rolNombre = $rolNombre ?? strtoupper(session()->get('user')['rol_nombre'] ?? '');
        $msg = $nombre ? "¡Bienvenido, {$nombre}!" : null;

        switch (strtoupper($rolNombre)) {
            case 'ADMIN':
                $redirect = redirect()->to('/dashboard');
                break;
            case 'JEFE':
                $redirect = redirect()->to('/reservas/pendientes');
                break;
            case 'MAESTRO':
                $redirect = redirect()->to('/reservas');
                break;
            default:
                $redirect = redirect()->to('/calendario');
                break;
        }

        return $msg ? $redirect->with('success', $msg) : $redirect;
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login')->with('success', 'Sesión cerrada correctamente.');
    }
}
