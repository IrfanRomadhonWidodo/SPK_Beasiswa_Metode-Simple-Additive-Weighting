<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAlternatifNilaiTable extends Migration
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
            'kode_kriteria' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
            ],
            'sub_kriteria_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
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
        $this->forge->addForeignKey('kode_alternatif', 'alternatif', 'kode_alternatif', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kode_kriteria', 'kriteria', 'kode_kriteria', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('sub_kriteria_id', 'sub_kriteria', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('alternatif_nilai');
    }

    public function down()
    {
        $this->forge->dropTable('alternatif_nilai');
    }
}