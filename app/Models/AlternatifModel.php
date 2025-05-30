<?php

namespace App\Models;

use CodeIgniter\Model;

class AlternatifModel extends Model
{
    protected $table            = 'alternatif';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode_alternatif', 'nama'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'kode_alternatif' => 'required|max_length[10]|is_unique[alternatif.kode_alternatif,id,{id}]',
        'nama'            => 'required|max_length[255]',
    ];

    protected $validationMessages = [
        'kode_alternatif' => [
            'required'    => 'Kode alternatif harus diisi',
            'max_length'  => 'Kode alternatif maksimal 10 karakter',
            'is_unique'   => 'Kode alternatif sudah digunakan'
        ],
        'nama' => [
            'required'    => 'Nama alternatif harus diisi',
            'max_length'  => 'Nama alternatif maksimal 255 karakter'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Additional methods for DataTables
    public function getDataForDataTables($request)
    {
        $columns = [
            0 => 'id',
            1 => 'kode_alternatif',
            2 => 'nama',
        ];

        $totalData = $this->countAll();

        $builder = $this->builder();

        // Search functionality
        if (!empty($request['search']['value'])) {
            $search = $request['search']['value'];
            $builder->groupStart()
                   ->like('kode_alternatif', $search)
                   ->orLike('nama', $search)
                   ->groupEnd();
        }

        $totalFiltered = $builder->countAllResults(false);

        // Order functionality
        if (isset($request['order'][0]['column'])) {
            $orderColumnIndex = $request['order'][0]['column'];
            $orderDir = $request['order'][0]['dir'];
            if (isset($columns[$orderColumnIndex])) {
                $builder->orderBy($columns[$orderColumnIndex], $orderDir);
            }
        } else {
            $builder->orderBy('id', 'ASC');
        }

        // Limit functionality
        if ($request['length'] != -1) {
            $builder->limit($request['length'], $request['start']);
        }

        $data = $builder->get()->getResultArray();

        // Add row numbers
        foreach ($data as $key => $row) {
            $data[$key]['no'] = $request['start'] + $key + 1;
        }

        return [
            'draw'            => intval($request['draw']),
            'recordsTotal'    => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data'            => $data
        ];
    }

    public function getNextKodeAlternatif()
    {
        $lastAlternatif = $this->select('kode_alternatif')
                              ->where('kode_alternatif REGEXP', '^A[0-9]+$')
                              ->orderBy('CAST(SUBSTRING(kode_alternatif, 2) AS UNSIGNED)', 'DESC')
                              ->first();

        if ($lastAlternatif) {
            $lastNumber = (int) substr($lastAlternatif['kode_alternatif'], 1);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return 'A' . $nextNumber;
    }
}