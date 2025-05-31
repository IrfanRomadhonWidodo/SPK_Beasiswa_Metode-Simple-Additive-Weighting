<?php

namespace App\Controllers;

use App\Models\AlternatifNilaiModel;
use CodeIgniter\Controller;
use App\Models\ProfileModel; 

class PerangkinganController extends Controller
{
    protected $alternatifNilaiModel;
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->alternatifNilaiModel = new AlternatifNilaiModel();
        $this->userModel = new ProfileModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $data = $this->getPerangkingan();
         // Cek apakah user sudah login
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        // Ambil data user
        $userId = $this->session->get('user_id');
        $user = $this->userModel->find($userId);
        $data['user'] = $user;
        // Tambahkan konten view ke dalam variabel $data['content']
        $data['content'] = view('peringkat_preferensi', $data);
        
        // Load dashboard.php sebagai shell layout
        return view('peringkat_preferensi', $data);
    }

    public function getPerangkingan()
    {
        // Ambil instance MatrikKeputusanController untuk menggunakan method normalisasi
        $matrikController = new \App\Controllers\MatrikKeputusanController();
        $dataNormalisasi = $matrikController->getNormalisasiMatrik();

        // Ambil data matriks normalisasi dan bobot preferensi
        $matrikNormalisasi = $dataNormalisasi['matrikNormalisasi'];
        $alternatifList = $dataNormalisasi['alternatifList'];
        $kriteriaList = $dataNormalisasi['kriteriaList'];

        // Ambil bobot preferensi dari AlternatifNilaiModel menggunakan method yang sudah ada
        $bobotPreferensiData = $this->alternatifNilaiModel->getMatrikKeputusanData();
        
        // Susun bobot preferensi dalam array dengan key kode_kriteria
        $bobotKriteria = [];
        foreach ($bobotPreferensiData as $data) {
            if (!isset($bobotKriteria[$data['kode_kriteria']])) {
                $bobotKriteria[$data['kode_kriteria']] = [
                    'bobot_preferensi' => (float) $data['bobot_preferensi'],
                    'variabel' => $data['variabel']
                ];
            }
        }

        // Hitung nilai preferensi untuk setiap alternatif
        $nilaiPreferensi = [];
        $detailPerhitungan = [];

        foreach ($alternatifList as $alternatif) {
            $totalNilai = 0;
            $detailAlternatif = [];
            $rumusPerhitungan = [];

            foreach (array_keys($kriteriaList) as $kriteria) {
                // Ambil nilai normalisasi dari matriks normalisasi
                $nilaiNormalisasi = $matrikNormalisasi[$alternatif][$kriteria] ?? 0;
                
                // Ambil bobot preferensi untuk kriteria ini
                $bobotPref = $bobotKriteria[$kriteria]['bobot_preferensi'] ?? 0;
                
                // Hitung kontribusi: nilai_normalisasi × bobot_preferensi
                $nilaiKontribusi = $nilaiNormalisasi * $bobotPref;
                $totalNilai += $nilaiKontribusi;

                // Simpan detail untuk ditampilkan
                $detailAlternatif[$kriteria] = [
                    'normalisasi' => round($nilaiNormalisasi, 4),
                    'bobot_preferensi' => $bobotPref,
                    'kontribusi' => round($nilaiKontribusi, 4)
                ];

                // Untuk menampilkan rumus perhitungan seperti contoh
                $rumusPerhitungan[] = "({$nilaiNormalisasi}) × ({$bobotPref})";

                log_message('info', "Alternatif $alternatif, Kriteria $kriteria: ($nilaiNormalisasi × $bobotPref) = $nilaiKontribusi");
            }

            // Bulatkan total nilai preferensi
            $nilaiPreferensi[$alternatif] = round($totalNilai, 4);
            $detailPerhitungan[$alternatif] = [
                'detail' => $detailAlternatif,
                'rumus' => implode(' + ', $rumusPerhitungan),
                'total' => round($totalNilai, 4)
            ];

            log_message('info', "Alternatif $alternatif: Vi = " . implode(' + ', $rumusPerhitungan) . " = $totalNilai");
        }

        // Urutkan berdasarkan nilai preferensi (descending - tertinggi ke terendah)
        arsort($nilaiPreferensi);

        // Buat ranking
        $peringkat = [];
        $rank = 1;
        foreach ($nilaiPreferensi as $alternatif => $nilai) {
            $peringkat[] = [
                'rank' => $rank,
                'alternatif' => $alternatif,
                'nilai_preferensi' => $nilai
            ];
            $rank++;
        }

        // Log hasil akhir perangkingan
        log_message('info', 'Hasil Perangkingan Final: ' . json_encode($peringkat));

        return [
            'peringkat' => $peringkat,
            'nilaiPreferensi' => $nilaiPreferensi,
            'detailPerhitungan' => $detailPerhitungan,
            'bobotKriteria' => $bobotKriteria,
            'matrikNormalisasi' => $matrikNormalisasi,
            'alternatifList' => $alternatifList,
            'kriteriaList' => $kriteriaList,
            'title' => 'Perangkingan Preferensi - Metode SAW'
        ];
    }

    public function getDataJSON()
    {
        $data = $this->getPerangkingan();
        return $this->response->setJSON($data);
    }

    /**
     * Method untuk menampilkan detail perhitungan dalam format yang mudah dibaca
     */
    public function getDetailPerhitungan()
    {
        $data = $this->getPerangkingan();
        
        $detailOutput = [];
        foreach ($data['detailPerhitungan'] as $alternatif => $detail) {
            $detailOutput[$alternatif] = [
                'alternatif' => $alternatif,
                'rumus_perhitungan' => $detail['rumus'],
                'hasil_perhitungan' => $detail['total'],
                'detail_per_kriteria' => $detail['detail']
            ];
        }

        return [
            'detail_perhitungan' => $detailOutput,
            'peringkat' => $data['peringkat'],
            'title' => 'Detail Perhitungan Nilai Preferensi'
        ];
    }

    /**
     * Method untuk export hasil perangkingan (opsional)
     */
    public function exportPerangkingan()
    {
        $data = $this->getPerangkingan();
        
        // Format data untuk export
        $exportData = [
            'tanggal_perhitungan' => date('Y-m-d H:i:s'),
            'metode' => 'Simple Additive Weighting (SAW)',
            'hasil_perangkingan' => $data['peringkat'],
            'detail_perhitungan' => $data['detailPerhitungan']
        ];

        return $this->response->setJSON($exportData);
    }
}