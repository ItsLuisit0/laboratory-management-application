<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Roles already exist (4 rows in DB), skip insertion
        echo "Verificando roles...\n";
        $rolesCount = $db->table('roles')->countAllResults();
        echo "Roles existentes: {$rolesCount}\n";

        // ── Get JEFE role ID ──────────────────────
        $jefeRol = $db->table('roles')->where('nombre', 'JEFE')->get()->getRow();
        if (!$jefeRol) {
            echo "ERROR: No se encontró el rol JEFE.\n";
            return;
        }
        $jefeRolId = $jefeRol->id_rol;
        echo "Rol JEFE encontrado con id_rol: {$jefeRolId}\n";

        // ── Insert Admin User ─────────────────────
        $adminEmail = 'admin@labcontrol.com';
        $existing = $db->table('usuarios')->where('correo', $adminEmail)->get()->getRow();

        if (!$existing) {
            $db->table('usuarios')->insert([
                'nombre'   => 'Administrador General',
                'correo'   => $adminEmail,
                'password' => hash('sha256', 'Admin123!'),
                'id_rol'   => $jefeRolId,
                'estado'   => 'ACTIVO',
            ]);
            echo "✅ Usuario admin creado: {$adminEmail} / Admin123!\n";
        } else {
            echo "Usuario admin ya existe: {$adminEmail}\n";
        }

        // ── Insert sample Maestro ─────────────────
        $maestroRol = $db->table('roles')->where('nombre', 'MAESTRO')->get()->getRow();
        $maestroEmail = 'maestro@labcontrol.com';
        $existing2 = $db->table('usuarios')->where('correo', $maestroEmail)->get()->getRow();
        if (!$existing2 && $maestroRol) {
            $db->table('usuarios')->insert([
                'nombre'   => 'Prof. García',
                'correo'   => $maestroEmail,
                'password' => hash('sha256', 'Maestro123!'),
                'id_rol'   => $maestroRol->id_rol,
                'estado'   => 'ACTIVO',
            ]);
            echo "✅ Usuario maestro creado: {$maestroEmail} / Maestro123!\n";
        }

        // ── Insert sample Labs ────────────────────
        $existingLab = $db->table('laboratorios')->where('nombre', 'Lab. Redes')->get()->getRow();
        if (!$existingLab) {
            $db->table('laboratorios')->insert([
                'nombre'      => 'Lab. Redes',
                'ubicacion'   => 'Edificio A, Planta 2',
                'capacidad'   => 30,
                'descripcion' => 'Laboratorio de redes y telecomunicaciones',
                'estado'      => 'DISPONIBLE',
            ]);
            echo "✅ Laboratorio 'Lab. Redes' creado.\n";
        }

        $existingLab2 = $db->table('laboratorios')->where('nombre', 'Lab. Programación')->get()->getRow();
        if (!$existingLab2) {
            $db->table('laboratorios')->insert([
                'nombre'      => 'Lab. Programación',
                'ubicacion'   => 'Edificio B, Planta 1',
                'capacidad'   => 25,
                'descripcion' => 'Laboratorio de programación y desarrollo de software',
                'estado'      => 'DISPONIBLE',
            ]);
            echo "✅ Laboratorio 'Lab. Programación' creado.\n";
        }

        echo "\n════════════════════════════════════════\n";
        echo "Credenciales de acceso:\n";
        echo "  JEFE:    admin@labcontrol.com / Admin123!\n";
        echo "  MAESTRO: maestro@labcontrol.com / Maestro123!\n";
        echo "════════════════════════════════════════\n";
    }
}
