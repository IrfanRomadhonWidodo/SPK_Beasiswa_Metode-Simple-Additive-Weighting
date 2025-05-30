<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PreferensiModel;
use App\Models\ProfileModel; 
use CodeIgniter\HTTP\ResponseInterface;

class Preferensi extends BaseController
{
    protected $preferensiModel;
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->preferensiModel = new PreferensiModel();
        $this->userModel = new ProfileModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        // Cek apakah user sudah login
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        // Ambil data user
        $userId = $this->session->get('user_id');
        $user = $this->userModel->find($userId);
        $data = [
            'title' => 'Data Preferensi',
            'user' => $user
        ];

        return view('data_preferensi', $data);
    }

    public function getData()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        $request = $this->request->getPost();
        $result = $this->preferensiModel->getDataTable($request);

        // Format data for DataTables
        foreach ($result['data'] as $key => $row) {
            $result['data'][$key]['no'] = $request['start'] + $key + 1;
        }

        return $this->response->setJSON($result);
    }

    public function store()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $rules = [
            'kode_kriteria' => 'required',
            'bobot_preferensi' => 'required|decimal|greater_than[0]' // ubah dari 'integer' ke 'decimal'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'kode_kriteria' => $this->request->getPost('kode_kriteria'),
            'bobot_preferensi' => $this->request->getPost('bobot_preferensi')
        ];

        if ($this->preferensiModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data preferensi berhasil ditambahkan'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menambahkan data preferensi',
                'errors' => $this->preferensiModel->errors()
            ]);
        }
    }

    public function show($id)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $data = $this->preferensiModel->find($id);

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

    public function update($id)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $rules = [
            'kode_kriteria' => "required|is_unique[preferensi.kode_kriteria,id,{$id}]",
            'bobot_preferensi' => 'required|decimal|greater_than[0]' // ubah dari 'integer' ke 'decimal'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'kode_kriteria' => $this->request->getPost('kode_kriteria'),
            'bobot_preferensi' => $this->request->getPost('bobot_preferensi')
        ];

        if ($this->preferensiModel->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data preferensi berhasil diupdate'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mengupdate data preferensi',
                'errors' => $this->preferensiModel->errors()
            ]);
        }
    }

    public function delete($id)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        if ($this->preferensiModel->delete($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data preferensi berhasil dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menghapus data preferensi'
            ]);
        }
    }

    public function getKriteriaOptions()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $options = $this->preferensiModel->getKriteriaOptions();

        return $this->response->setJSON([
            'success' => true,
            'data' => $options
        ]);
    }

    public function getTotalBobot()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $total = $this->preferensiModel->getTotalBobot();

        return $this->response->setJSON([
            'success' => true,
            'total' => $total
        ]);
    }
}