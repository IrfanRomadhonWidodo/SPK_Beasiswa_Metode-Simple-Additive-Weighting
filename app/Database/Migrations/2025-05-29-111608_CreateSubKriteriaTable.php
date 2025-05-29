<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubKriteriaTable extends Migration
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
            'kode_kriteria' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
            ],
            'sub_variabel' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'bobot' => [
                'type'       => 'INT',
                'constraint' => 11,
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
        $this->forge->addForeignKey('kode_kriteria', 'kriteria', 'kode_kriteria', 'CASCADE', 'CASCADE');
        $this->forge->createTable('sub_kriteria');
    }

    public function down()
    {
        $this->forge->dropTable('sub_kriteria');
    }
}