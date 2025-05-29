<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KriteriaModel;
use App\Models\ProfileModel; // Tambahkan ini

class KriteriaController extends BaseController
{
    protected $kriteriaModel;
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->kriteriaModel = new KriteriaModel();
        $this->userModel = new ProfileModel(); // Inisialisasi userModel
        $this->session = \Config\Services::session(); // Inisialisasi session
    }

    public function index()
    {
        // Cek apakah user sudah login
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        // Ambil data user untuk keperluan navbar
        $userId = $this->session->get('user_id');
        $user = $this->userModel->find($userId);

        $data = [
            'title' => 'Data Kriteria',
            'user' => $user
        ];

        return view('datakriteria', $data);
    }
    /**
     * Get kriteria data for DataTable (AJAX)
     */
    public function getData()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        $search = $this->request->getPost('search')['value'] ?? '';
        $start = (int) $this->request->getPost('start') ?? 0;
        $length = (int) $this->request->getPost('length') ?? 10;

        $data = $this->kriteriaModel->getKriteriaPaginated($length, $start, $search);
        $totalRecords = $this->kriteriaModel->countAll();
        $filteredRecords = $this->kriteriaModel->countKriteria($search);

        $response = [
            'draw' => (int) $this->request->getPost('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => array_map(function($row, $index) use ($start) {
                return [
                    'no' => $start + $index + 1,
                    'id' => $row['id'],
                    'kode_kriteria' => $row['kode_kriteria'],
                    'variabel' => $row['variabel'],
                    'jenis_kriteria' => $row['jenis_kriteria'],
                    'action' => ''
                ];
            }, $data, array_keys($data))
        ];

        return $this->response->setJSON($response);
    }

    /**
     * Store new kriteria
     */
    public function store()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $data = [
            'kode_kriteria' => $this->request->getPost('kode_kriteria'),
            'variabel' => $this->request->getPost('variabel'),
            'jenis_kriteria' => $this->request->getPost('jenis_kriteria')
        ];

        if ($this->kriteriaModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data kriteria berhasil ditambahkan'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menambahkan data',
                'errors' => $this->kriteriaModel->errors()
            ]);
        }
    }

    /**
     * Get single kriteria data
     */
    public function show($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $data = $this->kriteriaModel->find($id);
        
        if ($data) {
            return $this->response->setJSON([
                'success' => true,
                'data' => $data
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    /**
     * Update kriteria
     */
    public function update($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $data = [
            'kode_kriteria' => $this->request->getPost('kode_kriteria'),
            'variabel' => $this->request->getPost('variabel'),
            'jenis_kriteria' => $this->request->getPost('jenis_kriteria')
        ];

        if ($this->kriteriaModel->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data kriteria berhasil diupdate'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mengupdate data',
                'errors' => $this->kriteriaModel->errors()
            ]);
        }
    }

    /**
     * Delete kriteria
     */
    public function delete($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        if ($this->kriteriaModel->delete($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data kriteria berhasil dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menghapus data'
            ]);
        }
    }
}