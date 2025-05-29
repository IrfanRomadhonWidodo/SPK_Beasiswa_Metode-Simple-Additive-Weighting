<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKriteriaTable extends Migration
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
                'constraint' => '10',
                'null'       => false,
            ],
            'variabel' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'jenis_kriteria' => [
                'type'       => 'ENUM',
                'constraint' => ['Cost', 'Benefit'],
                'default'    => 'Benefit',
                'null'       => false,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('kode_kriteria');
        $this->forge->createTable('kriteria');
    }

    public function down()
    {
        $this->forge->dropTable('kriteria');
    }
}