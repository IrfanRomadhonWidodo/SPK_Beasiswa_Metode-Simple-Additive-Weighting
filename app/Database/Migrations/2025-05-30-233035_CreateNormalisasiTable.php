<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNormalisasiTable extends Migration
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
                'null'       => false,
            ],
            'kode_kriteria' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => false,
            ],
            'nilai_asli' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,4',
                'null'       => false,
            ],
            'hasil_normalisasi' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,4',
                'null'       => false,
            ],
            'jenis_kriteria' => [
                'type'       => 'ENUM',
                'constraint' => ['benefit', 'cost'],
                'null'       => false,
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
        $this->forge->addKey(['kode_alternatif', 'kode_kriteria']);
        $this->forge->createTable('normalisasi');
    }

    public function down()
    {
        $this->forge->dropTable('normalisasi');
    }
}