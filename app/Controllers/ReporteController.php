<?php

namespace App\Controllers;

use App\Models\ReservaModel;
use App\Models\LaboratorioModel;
use App\Models\UsuarioModel;
use App\Models\ReporteModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReporteController extends BaseController
{
    protected $reservaModel;
    protected $laboratorioModel;
    protected $usuarioModel;
    protected $reporteModel;

    public function __construct()
    {
        $this->reservaModel     = new ReservaModel();
        $this->laboratorioModel = new LaboratorioModel();
        $this->usuarioModel     = new UsuarioModel();
        $this->reporteModel     = new ReporteModel();
    }

    public function index()
    {
        $data = [
            'title'        => 'Generar Reporte',
            'laboratorios' => $this->laboratorioModel->getDropdown(),
            'maestros'     => $this->usuarioModel->getByRolNombre('MAESTRO'),
            'user'         => session()->get('user'),
        ];
        return view('reportes/index', $data);
    }

    public function generar()
    {
        $user = session()->get('user');

        $filters = [];
        $filterLabels = [];

        $laboratorioId = $this->request->getPost('id_laboratorio');
        $maestroId     = $this->request->getPost('id_maestro');
        $fechaInicio   = $this->request->getPost('fecha_inicio');
        $fechaFin      = $this->request->getPost('fecha_fin');
        $estado        = $this->request->getPost('estado');

        if (!empty($laboratorioId)) {
            $filters['id_laboratorio'] = $laboratorioId;
            $lab = $this->laboratorioModel->find($laboratorioId);
            $filterLabels['laboratorio'] = $lab ? $lab['nombre'] : '';
        }
        if (!empty($maestroId)) {
            $filters['id_maestro'] = $maestroId;
            $maestro = $this->usuarioModel->find($maestroId);
            $filterLabels['maestro'] = $maestro ? $maestro['nombre'] : '';
        }
        if (!empty($fechaInicio)) {
            $filters['fecha_inicio'] = $fechaInicio;
            $filterLabels['fecha_inicio'] = $fechaInicio;
        }
        if (!empty($fechaFin)) {
            $filters['fecha_fin'] = $fechaFin;
            $filterLabels['fecha_fin'] = $fechaFin;
        }
        if (!empty($estado)) {
            $filters['estado'] = $estado;
            $filterLabels['estado'] = $estado;
        }

        $reservas = $this->reservaModel->getReservasCompletas($filters);

        // Generate PDF
        $html = view('reportes/pdf_template', [
            'reservas'      => $reservas,
            'filters'       => $filterLabels,
            'fecha_reporte' => date('Y-m-d H:i:s'),
            'generado_por'  => $user['nombre'],
        ]);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Log the report
        $this->reporteModel->registrarReporte($user['id'], 'reservas', $filters);

        // Stream the PDF
        $archivo = 'reporte_' . date('Ymd_His') . '.pdf';
        $dompdf->stream($archivo, ['Attachment' => false]);
        exit;
    }

    public function historial()
    {
        $data = [
            'title'    => 'Historial de Reportes',
            'reportes' => $this->reporteModel->getReportesConUsuario(),
            'user'     => session()->get('user'),
        ];
        return view('reportes/historial', $data);
    }
}
