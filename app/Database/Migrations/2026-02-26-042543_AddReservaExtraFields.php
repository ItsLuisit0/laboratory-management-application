<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddReservaExtraFields extends Migration
{
    public function up()
    {
        $this->forge->addColumn('reservas', [
            'semestre' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'hora_fin',
            ],
            'carrera' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
                'after'      => 'semestre',
            ],
            'total_alumnos' => [
                'type'       => 'INT',
                'constraint' => 5,
                'null'       => true,
                'default'    => 0,
                'after'      => 'carrera',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('reservas', ['semestre', 'carrera', 'total_alumnos']);
    }
}
