<?php

namespace App\Controllers;

use App\Models\AlternatifNilaiModel;
use CodeIgniter\Controller;

class MatrikKeputusanController extends Controller
{
    protected $alternatifNilaiModel;

    public function __construct()
    {
        $this->alternatifNilaiModel = new AlternatifNilaiModel();
    }

    public function index()
    {
        $data = $this->getMatrikKeputusan();

        // Tambahkan konten view ke dalam variabel $data['content']
        $data['content'] = view('math/matrik_keputusan', $data);

        // Load dashboard.php sebagai shell layout
        return view('data_perhitungan', $data);
    }

    // UBAH DARI PRIVATE KE PUBLIC
    public function getMatrikKeputusan()
    {
        // Ambil semua data alternatif dengan nilai bobot
        $alternatifNilai = $this->alternatifNilaiModel
            ->select('alternatif_nilai.kode_alternatif, alternatif_nilai.kode_kriteria, 
                     sub_kriteria.bobot, sub_kriteria.sub_variabel, kriteria.variabel')
            ->join('sub_kriteria', 'sub_kriteria.id = alternatif_nilai.sub_kriteria_id')
            ->join('kriteria', 'kriteria.kode_kriteria = alternatif_nilai.kode_kriteria')
            ->orderBy('alternatif_nilai.kode_alternatif, alternatif_nilai.kode_kriteria')
            ->findAll();

        // Kelompokkan data berdasarkan alternatif dan kriteria
        $matrikData = [];
        $kriteriaList = [];
        $alternatifList = [];

        foreach ($alternatifNilai as $data) {
            $kodeAlternatif = $data['kode_alternatif'];
            $kodeKriteria = $data['kode_kriteria'];
            $bobot = $data['bobot'];
            $variabel = $data['variabel'];

            // Kumpulkan daftar alternatif dan kriteria
            if (!in_array($kodeAlternatif, $alternatifList)) {
                $alternatifList[] = $kodeAlternatif;
            }
            
            if (!isset($kriteriaList[$kodeKriteria])) {
                $kriteriaList[$kodeKriteria] = $variabel;
            }

            // Buat struktur matriks
            $matrikData[$kodeAlternatif][$kodeKriteria] = $bobot;
        }

        // Pastikan semua alternatif memiliki nilai untuk semua kriteria
        foreach ($alternatifList as $alternatif) {
            foreach (array_keys($kriteriaList) as $kriteria) {
                if (!isset($matrikData[$alternatif][$kriteria])) {
                    $matrikData[$alternatif][$kriteria] = 0;
                }
            }
        }

        return [
            'matrikData' => $matrikData,
            'kriteriaList' => $kriteriaList,
            'alternatifList' => $alternatifList,
            'title' => 'Matriks Keputusan - Metode SAW'
        ];
    }

    public function getMatrikData()
    {
        $data = $this->getMatrikKeputusan();
        return $this->response->setJSON($data);
    }
}