<?php

namespace App\Models;

use CodeIgniter\Model;

class AlternatifNilaiModel extends Model
{
    protected $table            = 'alternatif_nilai';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode_alternatif', 'kode_kriteria', 'sub_kriteria_id'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'kode_alternatif'  => 'required',
        'kode_kriteria'    => 'required',
        'sub_kriteria_id'  => 'required|integer',
    ];

    protected $validationMessages = [
        'kode_alternatif' => [
            'required' => 'Kode alternatif harus diisi'
        ],
        'kode_kriteria' => [
            'required' => 'Kode kriteria harus diisi'
        ],
        'sub_kriteria_id' => [
            'required' => 'Sub kriteria harus dipilih',
            'integer'  => 'Sub kriteria harus berupa angka'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getNilaiByAlternatif($kodeAlternatif)
    {
        return $this->select('alternatif_nilai.*, sub_kriteria.sub_variabel, sub_kriteria.bobot, kriteria.variabel')
                   ->join('sub_kriteria', 'sub_kriteria.id = alternatif_nilai.sub_kriteria_id')
                   ->join('kriteria', 'kriteria.kode_kriteria = alternatif_nilai.kode_kriteria')
                   ->where('kode_alternatif', $kodeAlternatif)
                   ->findAll();
    }

    public function deleteByAlternatif($kodeAlternatif)
    {
        return $this->where('kode_alternatif', $kodeAlternatif)->delete();
    }
}