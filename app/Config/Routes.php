<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ─── Public routes ───────────────────────────────────────
$routes->get('/', 'CalendarioController::publico');
$routes->get('auth/login', 'AuthController::login');
$routes->post('auth/authenticate', 'AuthController::authenticate');
$routes->get('auth/logout', 'AuthController::logout');

// Calendario público (sin autenticación)
$routes->get('calendario', 'CalendarioController::publico');
$routes->get('calendario/eventos', 'CalendarioController::eventosPublicos');

// ─── Protected routes (JWT required) ────────────────────
$routes->group('', ['filter' => 'jwt'], function ($routes) {

    // Dashboard (solo ADMIN)
    $routes->get('dashboard', 'DashboardController::index', ['filter' => 'role:ADMIN']);

    // Usuarios CRUD (solo ADMIN)
    $routes->group('usuarios', ['filter' => 'role:ADMIN'], function ($routes) {
        $routes->get('/', 'UsuarioController::index');
        $routes->get('crear', 'UsuarioController::create');
        $routes->post('store', 'UsuarioController::store');
        $routes->get('editar/(:num)', 'UsuarioController::edit/$1');
        $routes->post('update/(:num)', 'UsuarioController::update/$1');
        $routes->get('eliminar/(:num)', 'UsuarioController::delete/$1');
    });

    // Laboratorios CRUD (solo ADMIN)
    $routes->group('laboratorios', ['filter' => 'role:ADMIN'], function ($routes) {
        $routes->get('/', 'LaboratorioController::index');
        $routes->get('crear', 'LaboratorioController::create');
        $routes->post('store', 'LaboratorioController::store');
        $routes->get('editar/(:num)', 'LaboratorioController::edit/$1');
        $routes->post('update/(:num)', 'LaboratorioController::update/$1');
        $routes->get('eliminar/(:num)', 'LaboratorioController::delete/$1');
    });

    // Reservas — MAESTRO crea, JEFE aprueba/rechaza, ADMIN ve todo
    $routes->group('reservas', function ($routes) {
        $routes->get('/', 'ReservaController::index', ['filter' => 'role:MAESTRO,JEFE,ADMIN']);
        $routes->get('crear', 'ReservaController::create', ['filter' => 'role:MAESTRO']);
        $routes->post('store', 'ReservaController::store', ['filter' => 'role:MAESTRO']);
        $routes->get('pendientes', 'ReservaController::pendientes', ['filter' => 'role:JEFE']);
        $routes->post('aprobar/(:num)', 'ReservaController::aprobar/$1', ['filter' => 'role:JEFE']);
        $routes->post('rechazar/(:num)', 'ReservaController::rechazar/$1', ['filter' => 'role:JEFE']);
        $routes->get('detalle/(:num)', 'ReservaController::detalle/$1', ['filter' => 'role:MAESTRO,JEFE,ADMIN']);
    });

    // Prácticas (MAESTRO registra, ADMIN y JEFE pueden ver)
    $routes->group('practicas', ['filter' => 'role:MAESTRO,JEFE,ADMIN'], function ($routes) {
        $routes->get('/', 'PracticaController::index');
        $routes->get('crear/(:num)', 'PracticaController::create/$1');
        $routes->post('store', 'PracticaController::store');
        $routes->get('editar/(:num)', 'PracticaController::edit/$1');
        $routes->post('update/(:num)', 'PracticaController::update/$1');
    });

    // Reportes (solo ADMIN)
    $routes->group('reportes', ['filter' => 'role:ADMIN'], function ($routes) {
        $routes->get('/', 'ReporteController::index');
        $routes->post('generar', 'ReporteController::generar');
        $routes->get('historial', 'ReporteController::historial');
    });
});
