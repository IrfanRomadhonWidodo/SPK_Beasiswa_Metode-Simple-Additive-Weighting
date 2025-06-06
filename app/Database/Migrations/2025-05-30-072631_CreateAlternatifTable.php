<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAlternatifTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_alternatif' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('alternatif', true);
    }

    public function down()
    {
        $this->forge->dropTable('alternatif');
    }
}