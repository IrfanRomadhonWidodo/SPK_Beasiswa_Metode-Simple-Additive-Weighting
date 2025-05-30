<?php

namespace App\Models;

use CodeIgniter\Model;

class PreferensiModel extends Model
{
    protected $table = 'preferensi';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['kode_kriteria', 'bobot_preferensi'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
protected $validationRules = [
    'kode_kriteria' => 'required|is_unique[preferensi.kode_kriteria,id,{id}]',
    'bobot_preferensi' => 'required|decimal|greater_than[0]' // ubah dari 'integer' ke 'decimal'
];

    protected $validationMessages = [
        'kode_kriteria' => [
            'required' => 'Kode kriteria harus diisi',
            'is_unique' => 'Kode kriteria sudah ada'
        ],
'bobot_preferensi' => [
    'required' => 'Bobot preferensi harus diisi',
    'decimal' => 'Bobot preferensi harus berupa angka desimal', // ubah dari 'integer' ke 'decimal'
    'greater_than' => 'Bobot preferensi harus lebih dari 0'
]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Custom Methods
    public function getPreferensiWithKriteria()
    {
        return $this->select('preferensi.*, kriteria.variabel')
                    ->join('kriteria', 'kriteria.kode_kriteria = preferensi.kode_kriteria')
                    ->orderBy('preferensi.kode_kriteria', 'ASC')
                    ->findAll();
    }

    public function getDataTable($request)
    {
        $builder = $this->db->table($this->table)
                           ->select('preferensi.*, kriteria.variabel')
                           ->join('kriteria', 'kriteria.kode_kriteria = preferensi.kode_kriteria');

        // Handle search
        if ($request['search']['value']) {
            $searchValue = $request['search']['value'];
            $builder->groupStart()
                   ->like('preferensi.kode_kriteria', $searchValue)
                   ->orLike('kriteria.variabel', $searchValue)
                   ->orLike('preferensi.bobot_preferensi', $searchValue)
                   ->groupEnd();
        }

        // Handle ordering
        if (isset($request['order'][0]['column'])) {
            $columns = ['', 'preferensi.kode_kriteria', 'kriteria.variabel', 'preferensi.bobot_preferensi', ''];
            $columnIndex = $request['order'][0]['column'];
            if (isset($columns[$columnIndex]) && $columns[$columnIndex] != '') {
                $builder->orderBy($columns[$columnIndex], $request['order'][0]['dir']);
            }
        } else {
            $builder->orderBy('preferensi.kode_kriteria', 'ASC');
        }

        // Get total records without filtering
        $totalRecords = $this->db->table($this->table)->countAll();

        // Get total records with filtering
        $filteredRecords = $builder->countAllResults(false);

        // Get data with limit and offset
        $data = $builder->limit($request['length'], $request['start'])->get()->getResultArray();

        return [
            'draw' => intval($request['draw']),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];
    }

    public function getKriteriaOptions()
    {
        $kriteriaModel = new \App\Models\KriteriaModel();
        return $kriteriaModel->select('kode_kriteria, variabel')
                           ->orderBy('kode_kriteria', 'ASC')
                           ->findAll();
    }

    public function getTotalBobot()
    {
        return $this->selectSum('bobot_preferensi')->first()['bobot_preferensi'] ?? 0;
    }
}