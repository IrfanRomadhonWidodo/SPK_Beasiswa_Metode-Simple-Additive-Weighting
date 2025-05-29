<?php

namespace App\Controllers;

use App\Models\SubKriteriaModel;
use App\Models\KriteriaModel;
use App\Models\ProfileModel;


class SubKriteria extends BaseController
{
    protected $subKriteriaModel;
    protected $kriteriaModel;
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->subKriteriaModel = new SubKriteriaModel();
        $this->kriteriaModel = new KriteriaModel();
        $this->userModel = new ProfileModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        // Cek apakah user sudah login
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        // Ambil data user untuk ditampilkan di navbar/view
        $userId = $this->session->get('user_id');
        $user = $this->userModel->find($userId);

        $data = [
            'title' => 'Data Sub Kriteria',
            'user' => $user
        ];

        return view('sub_kriteria', $data);
    }


    public function getData()
    {
        if ($this->request->isAJAX()) {
            $request = $this->request->getPost();
            $data = $this->subKriteriaModel->getDataTables($request);
            
            // Add row numbers
            foreach ($data['data'] as $key => $row) {
                $data['data'][$key]['no'] = ($request['start'] ?? 0) + $key + 1;
            }
            
            return $this->response->setJSON($data);
        }
        
        return $this->response->setStatusCode(404);
    }

    public function getKriteriaOptions()
    {
        if ($this->request->isAJAX()) {
            $kriteria = $this->kriteriaModel->findAll();
            return $this->response->setJSON([
                'success' => true,
                'data' => $kriteria
            ]);
        }
        
        return $this->response->setStatusCode(404);
    }

    public function store()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'kode_kriteria' => $this->request->getPost('kode_kriteria'),
                'sub_variabel'  => $this->request->getPost('sub_variabel'),
                'bobot'         => $this->request->getPost('bobot')
            ];

            if ($this->subKriteriaModel->insert($data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Sub kriteria berhasil ditambahkan'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menambahkan sub kriteria',
                    'errors'  => $this->subKriteriaModel->errors()
                ]);
            }
        }
        
        return $this->response->setStatusCode(404);
    }

    public function show($id)
    {
        if ($this->request->isAJAX()) {
            $data = $this->subKriteriaModel->getWithKriteria($id);
            
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
        
        return $this->response->setStatusCode(404);
    }

    public function update($id)
    {
        if ($this->request->isAJAX()) {
            $data = [
                'kode_kriteria' => $this->request->getPost('kode_kriteria'),
                'sub_variabel'  => $this->request->getPost('sub_variabel'),
                'bobot'         => $this->request->getPost('bobot')
            ];

            if ($this->subKriteriaModel->update($id, $data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Sub kriteria berhasil diperbarui'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal memperbarui sub kriteria',
                    'errors'  => $this->subKriteriaModel->errors()
                ]);
            }
        }
        
        return $this->response->setStatusCode(404);
    }

    public function delete($id)
    {
        if ($this->request->isAJAX()) {
            if ($this->subKriteriaModel->delete($id)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Sub kriteria berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus sub kriteria'
                ]);
            }
        }
        
        return $this->response->setStatusCode(404);
    }

    
    
}