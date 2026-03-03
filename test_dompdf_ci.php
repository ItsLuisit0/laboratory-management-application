<?php
/**
 * Test script to bootstrap CI4 and run the reporting controller
 * to capture fatal DOMPDF errors
 */
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
chdir(FCPATH);

require FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

$app = \Config\Services::codeigniter();
$app->initialize();

// Mock session and DB
$session = \Config\Services::session();
$session->set('user', ['id' => 1, 'nombre' => 'Admin Test', 'rol_nombre' => 'ADMIN']);

try {
    echo "Running ReporteController->generar()...\n";
    $controller = new \App\Controllers\ReporteController();
    $controller->initController(
        \Config\Services::request(),
        \Config\Services::response(),
        \Config\Services::logger()
    );
    
    // Disable exit; in ReporteController to keep script alive
    $controller->generar();
    
} catch (\Throwable $e) {
    echo "\n=== FATAL ERROR ===\n";
    echo $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
