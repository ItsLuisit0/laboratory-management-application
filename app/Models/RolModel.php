<?php

namespace App\Models;

use CodeIgniter\Model;

class RolModel extends Model
{
    protected $table            = 'roles';
    protected $primaryKey       = 'id_rol';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nombre', 'descripcion'];
    protected $useTimestamps    = false;

    public function getRolByNombre(string $nombre): ?array
    {
        return $this->where('nombre', $nombre)->first();
    }

    public function getRolesDropdown(): array
    {
        $roles = $this->findAll();
        $dropdown = [];
        foreach ($roles as $rol) {
            $dropdown[$rol['id_rol']] = $rol['nombre'];
        }
        return $dropdown;
    }
}
