<?php

namespace App\Models;

use CodeIgniter\Model;

class SubKriteriaModel extends Model
{
    protected $table            = 'sub_kriteria';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode_kriteria', 'sub_variabel', 'bobot'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'kode_kriteria' => 'required|max_length[10]',
        'sub_variabel'  => 'required|max_length[255]',
        'bobot'         => 'required|integer|greater_than[0]'
    ];

    protected $validationMessages = [
        'kode_kriteria' => [
            'required'    => 'Kode kriteria harus diisi',
            'max_length'  => 'Kode kriteria maksimal 10 karakter'
        ],
        'sub_variabel' => [
            'required'    => 'Sub variabel harus diisi',
            'max_length'  => 'Sub variabel maksimal 255 karakter'
        ],
        'bobot' => [
            'required'      => 'Bobot harus diisi',
            'integer'       => 'Bobot harus berupa angka',
            'greater_than'  => 'Bobot harus lebih dari 0'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Get data with kriteria information
    public function getWithKriteria($id = null)
    {
        $builder = $this->db->table($this->table)
                           ->select('sub_kriteria.*, kriteria.variabel as nama_kriteria')
                           ->join('kriteria', 'kriteria.kode_kriteria = sub_kriteria.kode_kriteria');
        
        if ($id !== null) {
            return $builder->where('sub_kriteria.id', $id)->get()->getRowArray();
        }
        
        return $builder->get()->getResultArray();
    }

    // Get data for DataTables
    public function getDataTables($request)
    {
        $builder = $this->db->table($this->table)
                           ->select('sub_kriteria.*, kriteria.variabel as nama_kriteria')
                           ->join('kriteria', 'kriteria.kode_kriteria = sub_kriteria.kode_kriteria');

        // Search
        if (!empty($request['search']['value'])) {
            $searchValue = $request['search']['value'];
            $builder->groupStart()
                   ->like('sub_kriteria.kode_kriteria', $searchValue)
                   ->orLike('sub_kriteria.sub_variabel', $searchValue)
                   ->orLike('kriteria.variabel', $searchValue)
                   ->orLike('sub_kriteria.bobot', $searchValue)
                   ->groupEnd();
        }

        // Order
        if (isset($request['order'])) {
            $columns = ['', 'sub_kriteria.kode_kriteria', 'kriteria.variabel', 'sub_kriteria.sub_variabel', 'sub_kriteria.bobot', ''];
            $orderColumn = $columns[$request['order'][0]['column']] ?? 'sub_kriteria.id';
            $orderDir = $request['order'][0]['dir'] ?? 'asc';
            
            if ($orderColumn !== '') {
                $builder->orderBy($orderColumn, $orderDir);
            }
        }

        // Count total records
        $totalRecords = $this->db->table($this->table)
                                ->join('kriteria', 'kriteria.kode_kriteria = sub_kriteria.kode_kriteria')
                                ->countAllResults();

        // Count filtered records
        $filteredRecords = clone $builder;
        $filteredRecords = $filteredRecords->countAllResults(false);

        // Get data with limit
        if (isset($request['length']) && $request['length'] != -1) {
            $builder->limit($request['length'], $request['start'] ?? 0);
        }

        $data = $builder->get()->getResultArray();

        return [
            'draw' => intval($request['draw'] ?? 1),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];
    }

    public function getGroupedWithKriteria()
{
    $builder = $this->db->table('sub_kriteria sk')
        ->select('sk.*, k.variabel as nama_kriteria')
        ->join('kriteria k', 'sk.kode_kriteria = k.kode_kriteria')
        ->orderBy('sk.kode_kriteria')
        ->orderBy('sk.id');

    return $builder->get()->getResultArray();
}

}