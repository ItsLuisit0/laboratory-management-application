<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id_usuario';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'nombre', 'correo', 'password', 'id_rol', 'estado'
    ];
    protected $useTimestamps    = false;

    protected $validationRules = [
        'nombre'  => 'required|min_length[2]|max_length[100]',
        'correo'  => 'required|valid_email|max_length[100]',
        'id_rol'  => 'required|integer',
    ];

    /**
     * Hash password with SHA-256 before insert
     */
    protected function hashPassword(array $data): array
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = hash('sha256', $data['data']['password']);
        }
        return $data;
    }

    protected $beforeInsert = ['hashPassword'];

    /**
     * Authenticate user by email and password
     */
    public function authenticate(string $correo, string $password): ?array
    {
        $hashedPassword = hash('sha256', $password);
        return $this->where('correo', $correo)
                    ->where('password', $hashedPassword)
                    ->where('estado', 'ACTIVO')
                    ->first();
    }

    /**
     * Get user with role info
     */
    public function getUsuarioConRol(int $id): ?array
    {
        return $this->select('usuarios.*, roles.nombre as rol_nombre')
                    ->join('roles', 'roles.id_rol = usuarios.id_rol')
                    ->where('usuarios.id_usuario', $id)
                    ->first();
    }

    /**
     * Get all users with role info
     */
    public function getUsuariosConRol(array $filters = []): array
    {
        $builder = $this->select('usuarios.*, roles.nombre as rol_nombre')
                        ->join('roles', 'roles.id_rol = usuarios.id_rol');

        if (!empty($filters['id_rol'])) {
            $builder->where('usuarios.id_rol', $filters['id_rol']);
        }

        if (!empty($filters['search'])) {
            $builder->groupStart()
                    ->like('usuarios.nombre', $filters['search'])
                    ->orLike('usuarios.correo', $filters['search'])
                    ->groupEnd();
        }

        return $builder->orderBy('usuarios.nombre', 'ASC')->findAll();
    }

    /**
     * Check if email exists
     */
    public function emailExists(string $correo, ?int $excludeId = null): bool
    {
        $builder = $this->where('correo', $correo);
        if ($excludeId) {
            $builder->where('id_usuario !=', $excludeId);
        }
        return $builder->countAllResults() > 0;
    }

    /**
     * Get users by role name
     */
    public function getByRolNombre(string $rolNombre): array
    {
        return $this->select('usuarios.*, roles.nombre as rol_nombre')
                    ->join('roles', 'roles.id_rol = usuarios.id_rol')
                    ->where('roles.nombre', $rolNombre)
                    ->findAll();
    }
}
