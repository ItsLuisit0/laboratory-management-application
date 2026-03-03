<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // 1. Get the content of the view to render
    $html = file_get_contents('app/Views/reportes/pdf_template.php');

    // MOCK data to simulate variables
    $html = str_replace('<?= esc($fecha_reporte) ?>', date('Y-m-d H:i:s'), $html);
    $html = str_replace('<?= esc($generado_por) ?>', 'TEST_USER', $html);
    $html = str_replace('<?= count($reservas) ?>', '0', $html);
    
    // Remove PHP blocks for simplicity in raw test
    $html = preg_replace('/<\?php.*?\?>/s', '', $html);

    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    $options->set('defaultFont', 'Helvetica');

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    
    echo "Rendering start...\n";
    $dompdf->render();
    echo "Rendering success!\n";
    
} catch (\Throwable $e) {
    echo "FATAL ERROR:\n";
    echo $e->getMessage() . "\n";
    echo $e->getFile() . ":" . $e->getLine() . "\n";
}
