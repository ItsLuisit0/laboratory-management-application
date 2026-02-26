<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class JwtFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('jwt');

        $session = session();
        $token = $session->get('jwt_token');

        if (!$token) {
            if ($request->isAJAX()) {
                return service('response')
                    ->setStatusCode(401)
                    ->setJSON(['error' => 'No autenticado']);
            }
            return redirect()->to('/auth/login')->with('error', 'Debe iniciar sesión para acceder.');
        }

        $decoded = validateJWT($token);

        if (!$decoded) {
            $session->destroy();
            if ($request->isAJAX()) {
                return service('response')
                    ->setStatusCode(401)
                    ->setJSON(['error' => 'Token inválido o expirado']);
            }
            return redirect()->to('/auth/login')->with('error', 'Sesión expirada. Inicie sesión nuevamente.');
        }

        // Store user data in session for easy access
        $session->set('user', (array) $decoded->data);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do after
    }
}
