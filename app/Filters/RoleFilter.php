<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    /**
     * $arguments contains the allowed role names, e.g. ['JEFE', 'RESPONSABLE']
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $user = $session->get('user');

        if (!$user) {
            if ($request->isAJAX()) {
                return service('response')
                    ->setStatusCode(401)
                    ->setJSON(['error' => 'No autenticado']);
            }
            return redirect()->to('/auth/login');
        }

        $userRole = strtoupper($user['rol_nombre'] ?? '');

        // If no specific roles are required, allow any authenticated user
        if (empty($arguments)) {
            return;
        }

        // Check if user's role is in the allowed list
        $allowedRoles = array_map('strtoupper', $arguments);

        if (!in_array($userRole, $allowedRoles)) {
            if ($request->isAJAX()) {
                return service('response')
                    ->setStatusCode(403)
                    ->setJSON(['error' => 'No tiene permisos para acceder a este recurso']);
            }
            return redirect()->to('/dashboard')->with('error', 'No tiene permisos para acceder a esa sección.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do after
    }
}
