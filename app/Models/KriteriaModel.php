<?php

namespace App\Models;

use CodeIgniter\Model;

class KriteriaModel extends Model
{
    protected $table            = 'kriteria';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode_kriteria', 'variabel', 'jenis_kriteria'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'kode_kriteria'  => 'required|max_length[10]|is_unique[kriteria.kode_kriteria,id,{id}]',
        'variabel'       => 'required|max_length[100]',
        'jenis_kriteria' => 'required|in_list[Cost,Benefit]'
    ];

    protected $validationMessages = [
        'kode_kriteria' => [
            'required'    => 'Kode kriteria harus diisi',
            'max_length'  => 'Kode kriteria maksimal 10 karakter',
            'is_unique'   => 'Kode kriteria sudah ada'
        ],
        'variabel' => [
            'required'   => 'Variabel harus diisi',
            'max_length' => 'Variabel maksimal 100 karakter'
        ],
        'jenis_kriteria' => [
            'required' => 'Jenis kriteria harus dipilih',
            'in_list'  => 'Jenis kriteria harus Cost atau Benefit'
        ]
    ];

    protected $skipValidation = false;
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
     * Get all kriteria with pagination
     */
    public function getKriteriaPaginated($limit = 10, $offset = 0, $search = '')
    {
        $builder = $this->builder();
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('kode_kriteria', $search)
                    ->orLike('variabel', $search)
                    ->orLike('jenis_kriteria', $search)
                    ->groupEnd();
        }

        return $builder->limit($limit, $offset)->get()->getResultArray();
    }

    /**
     * Count all kriteria with search
     */
    public function countKriteria($search = '')
    {
        $builder = $this->builder();
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('kode_kriteria', $search)
                    ->orLike('variabel', $search)
                    ->orLike('jenis_kriteria', $search)
                    ->groupEnd();
        }

        return $builder->countAllResults();
    }
}