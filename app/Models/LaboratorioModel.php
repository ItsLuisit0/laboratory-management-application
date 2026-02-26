<?php

namespace App\Models;

use CodeIgniter\Model;

class LaboratorioModel extends Model
{
    protected $table            = 'laboratorios';
    protected $primaryKey       = 'id_laboratorio';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'nombre', 'ubicacion', 'capacidad', 'descripcion', 'estado'
    ];
    protected $useTimestamps    = false;

    protected $validationRules = [
        'nombre'    => 'required|min_length[2]|max_length[100]',
        'ubicacion' => 'required|max_length[150]',
        'capacidad' => 'required|integer|greater_than[0]',
    ];

    /**
     * Get active labs (DISPONIBLE)
     */
    public function getActivos(): array
    {
        return $this->where('estado', 'DISPONIBLE')->orderBy('nombre', 'ASC')->findAll();
    }

    /**
     * Get labs as dropdown options
     */
    public function getDropdown(): array
    {
        $labs = $this->getActivos();
        $dropdown = [];
        foreach ($labs as $lab) {
            $dropdown[$lab['id_laboratorio']] = $lab['nombre'];
        }
        return $dropdown;
    }
}
