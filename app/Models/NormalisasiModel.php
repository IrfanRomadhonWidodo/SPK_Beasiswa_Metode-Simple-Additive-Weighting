<?php

namespace App\Models;

use CodeIgniter\Model;

class NormalisasiModel extends Model
{
    protected $table            = 'normalisasi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kode_alternatif',
        'kode_kriteria', 
        'nilai_asli',
        'hasil_normalisasi',
        'jenis_kriteria'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Get normalisasi data as matrix format
     */
    public function getMatrikNormalisasi()
    {
        $normalisasi = $this->orderBy('kode_alternatif, kode_kriteria')->findAll();
        
        $matrikData = [];
        $kriteriaList = [];
        $alternatifList = [];

        foreach ($normalisasi as $data) {
            $kodeAlternatif = $data['kode_alternatif'];
            $kodeKriteria = $data['kode_kriteria'];
            
            if (!in_array($kodeAlternatif, $alternatifList)) {
                $alternatifList[] = $kodeAlternatif;
            }
            
            if (!in_array($kodeKriteria, $kriteriaList)) {
                $kriteriaList[] = $kodeKriteria;
            }

            $matrikData[$kodeAlternatif][$kodeKriteria] = [
                'nilai_asli' => $data['nilai_asli'],
                'hasil_normalisasi' => $data['hasil_normalisasi'],
                'jenis_kriteria' => $data['jenis_kriteria']
            ];
        }

        return [
            'matrikData' => $matrikData,
            'kriteriaList' => $kriteriaList,
            'alternatifList' => $alternatifList
        ];
    }

    /**
     * Clear all normalisasi data
     */
    public function clearData()
    {
        return $this->emptyTable();
    }

    /**
     * Insert batch data
     */
    public function insertBatchData($data)
    {
        return $this->insertBatch($data);
    }
}