<?php

namespace App\Controllers;

use App\Models\NormalisasiModel;
use App\Models\KriteriaModel;
use App\Models\AlternatifNilaiModel;
use CodeIgniter\Controller;

class NormalisasiController extends Controller
{
    protected $normalisasiModel;
    protected $kriteriaModel;
    protected $alternatifNilaiModel;

    public function __construct()
    {
        $this->normalisasiModel = new NormalisasiModel();
        $this->kriteriaModel = new KriteriaModel();
        $this->alternatifNilaiModel = new AlternatifNilaiModel();
    }

public function index()
{
    // Ambil data normalisasi dari model
    $normalisasiData = $this->normalisasiModel->getMatrikNormalisasi();

    // Siapkan data yang akan dikirim ke view
    $data = [
        'title' => 'Normalisasi Matriks - Metode SAW',
        'matrikData' => $normalisasiData['matrikData'],
        'kriteriaList' => $normalisasiData['kriteriaList'],
        'alternatifList' => $normalisasiData['alternatifList'],
        'hasData' => !empty($normalisasiData['matrikData']) // <= ini penting
    ];

    // Masukkan isi view normalisasi ke bagian konten
    $data['content'] = view('math/normalisasi_matrik', $data);

    // Tampilkan semua ke dalam template utama
    return view('data_perhitungan', $data);
}


    public function prosesNormalisasi()
    {
        try {
            // Clear existing data
            $this->normalisasiModel->clearData();

            // Get data from MatrikKeputusanController
            $matrikController = new \App\Controllers\MatrikKeputusanController();
            $matrikData = $matrikController->getMatrikKeputusan();

            // Get kriteria types (benefit/cost)
            $kriteriaTypes = $this->getKriteriaTypes();

            // Build matrix format for calculation
            $matriks = $this->buildMatriks($matrikData['matrikData']);

            // Process normalization
            $hasilNormalisasi = $this->calculateNormalization($matriks, $kriteriaTypes);

            // Save to database
            if (!empty($hasilNormalisasi)) {
                $this->normalisasiModel->insertBatchData($hasilNormalisasi);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Normalisasi berhasil diproses',
                'data_count' => count($hasilNormalisasi)
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    private function getKriteriaTypes()
    {
        $kriteria = $this->kriteriaModel->findAll();
        $types = [];
        
        foreach ($kriteria as $k) {
            $types[$k['kode_kriteria']] = $k['jenis_kriteria'];
        }
        
        return $types;
    }

    private function buildMatriks($matrikData)
    {
        $matriks = [];
        
        foreach ($matrikData as $kodeAlternatif => $kriteria) {
            foreach ($kriteria as $kodeKriteria => $bobot) {
                $matriks[$kodeKriteria][$kodeAlternatif] = $bobot;
            }
        }
        
        return $matriks;
    }

    private function calculateNormalization($matriks, $kriteriaTypes)
    {
        $hasil = [];
        
        foreach ($matriks as $kodeKriteria => $alternatifBobot) {
            $jenisKriteria = $kriteriaTypes[$kodeKriteria] ?? 'benefit';
            $bobotList = array_values($alternatifBobot);
            
            if ($jenisKriteria === 'benefit') {
                $maxBobot = max($bobotList);
                
                foreach ($alternatifBobot as $kodeAlternatif => $bobot) {
                    $nilaiNormalisasi = $maxBobot > 0 ? $bobot / $maxBobot : 0;
                    
                    $hasil[] = [
                        'kode_alternatif' => $kodeAlternatif,
                        'kode_kriteria' => $kodeKriteria,
                        'nilai_asli' => $bobot,
                        'hasil_normalisasi' => round($nilaiNormalisasi, 4),
                        'jenis_kriteria' => $jenisKriteria
                    ];
                }
            } elseif ($jenisKriteria === 'cost') {
                $minBobot = min($bobotList);
                
                foreach ($alternatifBobot as $kodeAlternatif => $bobot) {
                    $nilaiNormalisasi = $bobot > 0 ? $minBobot / $bobot : 0;
                    
                    $hasil[] = [
                        'kode_alternatif' => $kodeAlternatif,
                        'kode_kriteria' => $kodeKriteria,
                        'nilai_asli' => $bobot,
                        'hasil_normalisasi' => round($nilaiNormalisasi, 4),
                        'jenis_kriteria' => $jenisKriteria
                    ];
                }
            }
        }
        
        return $hasil;
    }

    public function getMatrikData()
    {
        $data = $this->normalisasiModel->getMatrikNormalisasi();
        return $this->response->setJSON($data);
    }

    public function resetData()
    {
        try {
            $this->normalisasiModel->clearData();
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data normalisasi berhasil dihapus'
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}