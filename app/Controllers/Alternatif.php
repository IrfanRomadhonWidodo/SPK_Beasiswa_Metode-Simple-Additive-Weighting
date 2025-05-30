<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AlternatifModel;
use App\Models\AlternatifNilaiModel;
use App\Models\KriteriaModel;
use App\Models\SubKriteriaModel;

class Alternatif extends BaseController
{
    protected $alternatifModel;
    protected $alternatifNilaiModel;
    protected $kriteriaModel;
    protected $subKriteriaModel;

    public function __construct()
    {
        $this->alternatifModel = new AlternatifModel();
        $this->alternatifNilaiModel = new AlternatifNilaiModel();
        $this->kriteriaModel = new KriteriaModel();
        $this->subKriteriaModel = new SubKriteriaModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Alternatif'
        ];

        return view('data_alternatif', $data);
    }

    public function getData()
    {
        if ($this->request->isAJAX()) {
            $request = $this->request->getPost();
            $data = $this->alternatifModel->getDataForDataTables($request);
            
            return $this->response->setJSON($data);
        }
        
        return $this->response->setStatusCode(403);
    }

    public function store()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'kode_alternatif' => $this->request->getPost('kode_alternatif'),
                'nama' => $this->request->getPost('nama'),
            ];

            if ($this->alternatifModel->save($data)) {
                $alternatifId = $this->alternatifModel->getInsertID();
                $kodeAlternatif = $data['kode_alternatif'];

                // Save nilai alternatif for each kriteria
                $kriteriaList = $this->request->getPost('kriteria');
                if ($kriteriaList) {
                    foreach ($kriteriaList as $kodeKriteria => $subKriteriaId) {
                        if (!empty($subKriteriaId)) {
                            $nilaiData = [
                                'kode_alternatif' => $kodeAlternatif,
                                'kode_kriteria' => $kodeKriteria,
                                'sub_kriteria_id' => $subKriteriaId
                            ];
                            $this->alternatifNilaiModel->save($nilaiData);
                        }
                    }
                }

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data alternatif berhasil ditambahkan'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data alternatif gagal ditambahkan',
                    'errors' => $this->alternatifModel->errors()
                ]);
            }
        }
        
        return $this->response->setStatusCode(403);
    }

    public function show($id)
    {
        if ($this->request->isAJAX()) {
            $alternatif = $this->alternatifModel->find($id);
            
            if ($alternatif) {
                // Get nilai alternatif
                $nilai = $this->alternatifNilaiModel->getNilaiByAlternatif($alternatif['kode_alternatif']);
                $alternatif['nilai'] = $nilai;

                return $this->response->setJSON([
                    'success' => true,
                    'data' => $alternatif
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        
        return $this->response->setStatusCode(403);
    }

    public function update($id)
    {
        if ($this->request->isAJAX()) {
            $alternatif = $this->alternatifModel->find($id);
            
            if (!$alternatif) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            $data = [
                'kode_alternatif' => $this->request->getPost('kode_alternatif'),
                'nama' => $this->request->getPost('nama'),
            ];

            if ($this->alternatifModel->update($id, $data)) {
                $kodeAlternatif = $data['kode_alternatif'];

                // Delete existing nilai alternatif
                $this->alternatifNilaiModel->deleteByAlternatif($kodeAlternatif);

                // Save new nilai alternatif
                $kriteriaList = $this->request->getPost('kriteria');
                if ($kriteriaList) {
                    foreach ($kriteriaList as $kodeKriteria => $subKriteriaId) {
                        if (!empty($subKriteriaId)) {
                            $nilaiData = [
                                'kode_alternatif' => $kodeAlternatif,
                                'kode_kriteria' => $kodeKriteria,
                                'sub_kriteria_id' => $subKriteriaId
                            ];
                            $this->alternatifNilaiModel->save($nilaiData);
                        }
                    }
                }

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data alternatif berhasil diupdate'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data alternatif gagal diupdate',
                    'errors' => $this->alternatifModel->errors()
                ]);
            }
        }
        
        return $this->response->setStatusCode(403);
    }

    public function delete($id)
    {
        if ($this->request->isAJAX()) {
            $alternatif = $this->alternatifModel->find($id);
            
            if (!$alternatif) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            // Delete nilai alternatif first
            $this->alternatifNilaiModel->deleteByAlternatif($alternatif['kode_alternatif']);

            if ($this->alternatifModel->delete($id)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data alternatif berhasil dihapus'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Data alternatif gagal dihapus'
                ]);
            }
        }
        
        return $this->response->setStatusCode(403);
    }

    public function getKriteria()
    {
        if ($this->request->isAJAX()) {
            $kriteria = $this->kriteriaModel->findAll();
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $kriteria
            ]);
        }
        
        return $this->response->setStatusCode(403);
    }

    public function getSubKriteria($kodeKriteria)
    {
        if ($this->request->isAJAX()) {
            $subKriteria = $this->subKriteriaModel->where('kode_kriteria', $kodeKriteria)->findAll();
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $subKriteria
            ]);
        }
        
        return $this->response->setStatusCode(403);
    }

    public function getNextKode()
    {
        if ($this->request->isAJAX()) {
            $nextKode = $this->alternatifModel->getNextKodeAlternatif();
            
            return $this->response->setJSON([
                'success' => true,
                'kode' => $nextKode
            ]);
        }
        
        return $this->response->setStatusCode(403);
    }
}