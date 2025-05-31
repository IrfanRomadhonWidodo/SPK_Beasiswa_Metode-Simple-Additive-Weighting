<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\MatrikKeputusanController;
use App\Models\ProfileModel;

class DataPerhitunganController extends BaseController
{
    protected $session;
    protected $userModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->userModel = new ProfileModel();
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

        // Ambil data matriks dari MatrikKeputusanController
        $matrikController = new MatrikKeputusanController();
        $matriksData = $matrikController->getMatrikKeputusan();
        
        // Ambil data normalisasi
        $normalisasiData = $matrikController->getNormalisasiMatrik();
        
        // Gabungkan data matriks dan normalisasi
        $combinedData = array_merge($matriksData, $normalisasiData);

        // Gabungkan data untuk dikirim ke view
        $data = [
            'title' => 'Data Perhitungan',
            'user' => $user,
            'content' => view('math/matrik_keputusan', $combinedData)
        ];

        return view('data_perhitungan', $data);
    }
    
    // Method khusus untuk menampilkan hanya matriks keputusan
    public function matrikKeputusan()
    {
        // Cek apakah user sudah login
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        // Ambil data user
        $userId = $this->session->get('user_id');
        $user = $this->userModel->find($userId);

        // Ambil data matriks dari MatrikKeputusanController
        $matrikController = new MatrikKeputusanController();
        $matriksData = $matrikController->getMatrikKeputusan();

        // Gabungkan data untuk dikirim ke view
        $data = [
            'title' => 'Matriks Keputusan',
            'user' => $user,
            'content' => view('math/matrik_keputusan', $matriksData)
        ];

        return view('data_perhitungan', $data);
    }
    
    // Method khusus untuk menampilkan normalisasi
    public function normalisasi()
    {
        // Cek apakah user sudah login
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        // Ambil data user
        $userId = $this->session->get('user_id');
        $user = $this->userModel->find($userId);

        // Ambil data dari MatrikKeputusanController
        $matrikController = new MatrikKeputusanController();
        $matriksData = $matrikController->getMatrikKeputusan();
        $normalisasiData = $matrikController->getNormalisasiMatrik();
        
        // Gabungkan data matriks dan normalisasi
        $combinedData = array_merge($matriksData, $normalisasiData);

        // Gabungkan data untuk dikirim ke view
        $data = [
            'title' => 'Normalisasi Matriks',
            'user' => $user,
            'content' => view('math/matrik_keputusan', $combinedData)
        ];

        return view('data_perhitungan', $data);
    }
}