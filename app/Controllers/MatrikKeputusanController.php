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

  public function normalisasi()
{
    $data = $this->getMatrikKeputusan();
    $dataNormalisasi = $this->getNormalisasiMatrik();
    
    // Gabungkan data matriks keputusan dan normalisasi
    $data = array_merge($data, $dataNormalisasi);
    
    // Tambahkan konten view ke dalam variabel $data['content']
    $data['content'] = view('math/matrik_keputusan', $data);

    // Load dashboard.php sebagai shell layout
    return view('data_perhitungan', $data);
}

public function getNormalisasiMatrik()
{
    // Ambil data dengan jenis kriteria
    $alternatifNilai = $this->alternatifNilaiModel
        ->select('alternatif_nilai.kode_alternatif, alternatif_nilai.kode_kriteria, 
                 sub_kriteria.bobot, kriteria.jenis_kriteria, kriteria.variabel')
        ->join('sub_kriteria', 'sub_kriteria.id = alternatif_nilai.sub_kriteria_id')
        ->join('kriteria', 'kriteria.kode_kriteria = alternatif_nilai.kode_kriteria')
        ->orderBy('alternatif_nilai.kode_alternatif, alternatif_nilai.kode_kriteria')
        ->findAll();

    // Debug: Tampilkan data yang diambil dari database
    log_message('info', 'Data dari database: ' . json_encode($alternatifNilai));

    // Susun data ke dalam matriks dengan struktur alternatif -> kriteria
    $matriks = [];
    $jenisKriteria = [];
    $kriteriaList = [];
    $alternatifList = [];

    foreach ($alternatifNilai as $data) {
        $kodeAlternatif = $data['kode_alternatif'];
        $kodeKriteria = $data['kode_kriteria'];
        $bobot = (float) $data['bobot']; // Pastikan tipe data float
        $jenis = $data['jenis_kriteria'];
        $variabel = $data['variabel'];

        // Kumpulkan daftar alternatif dan kriteria
        if (!in_array($kodeAlternatif, $alternatifList)) {
            $alternatifList[] = $kodeAlternatif;
        }
        
        if (!isset($kriteriaList[$kodeKriteria])) {
            $kriteriaList[$kodeKriteria] = $variabel;
        }

        // Buat struktur matriks [alternatif][kriteria] = bobot
        $matriks[$kodeAlternatif][$kodeKriteria] = $bobot;
        $jenisKriteria[$kodeKriteria] = $jenis;
    }

    // Pastikan semua alternatif memiliki nilai untuk semua kriteria
    foreach ($alternatifList as $alternatif) {
        foreach (array_keys($kriteriaList) as $kriteria) {
            if (!isset($matriks[$alternatif][$kriteria])) {
                $matriks[$alternatif][$kriteria] = 0;
            }
        }
    }

    // Sort alternatif dan kriteria untuk konsistensi
    sort($alternatifList);
    uksort($kriteriaList, function ($a, $b) {
    return (int) substr($a, 1) <=> (int) substr($b, 1);
});

    // Debug: Tampilkan matriks yang terbentuk
    log_message('info', 'Matriks yang terbentuk: ' . json_encode($matriks));
    log_message('info', 'Jenis kriteria: ' . json_encode($jenisKriteria));

    // PERBAIKAN: Hitung nilai max dan min per kriteria terlebih dahulu
    $statsKriteria = [];
    foreach (array_keys($kriteriaList) as $kodeKriteria) {
        $bobotKriteria = [];
        
        // Kumpulkan semua nilai untuk kriteria ini dari semua alternatif
        foreach ($alternatifList as $alternatif) {
            $bobotKriteria[] = $matriks[$alternatif][$kodeKriteria];
        }
        
        $maxBobot = max($bobotKriteria);
        $minBobot = min($bobotKriteria);
        
        // Untuk cost criteria, jika ada nilai 0, gunakan nilai minimum dari yang > 0
        if ($jenisKriteria[$kodeKriteria] === 'Cost') {
            $bobotNonZero = array_filter($bobotKriteria, function($val) { return $val > 0; });
            if (!empty($bobotNonZero)) {
                $minBobot = min($bobotNonZero);
            }
        }
        
        $statsKriteria[$kodeKriteria] = [
            'max' => $maxBobot,
            'min' => $minBobot,
            'jenis' => $jenisKriteria[$kodeKriteria],
            'bobot_asli' => array_combine($alternatifList, $bobotKriteria)
        ];
        
        // Debug per kriteria
        log_message('info', "Kriteria $kodeKriteria ({$jenisKriteria[$kodeKriteria]}): bobot = " . json_encode($bobotKriteria) . ", max = $maxBobot, min = $minBobot");
    }

    // Hitung normalisasi PER KRITERIA (kolom demi kolom)
    $matrikNormalisasi = [];
    $detailPerhitungan = [];

    // PERBAIKAN: Loop per kriteria dulu (kolom demi kolom)
    foreach (array_keys($kriteriaList) as $kodeKriteria) {
        $jenis = $jenisKriteria[$kodeKriteria];
        $maxBobot = $statsKriteria[$kodeKriteria]['max'];
        $minBobot = $statsKriteria[$kodeKriteria]['min'];
        
        log_message('info', "=== Memproses Kriteria $kodeKriteria (Jenis: $jenis) ===");
        log_message('info', "Max bobot: $maxBobot, Min bobot: $minBobot");
        
        // Loop untuk setiap alternatif dalam kriteria ini
        foreach ($alternatifList as $alternatif) {
            $bobot = $matriks[$alternatif][$kodeKriteria];
            
            if ($jenis === 'Benefit') {
                // Untuk benefit: Normalisasi[Ai][Cj] = Matriks[Ai][Cj] / max(Matriks[*][Cj])
                $nilaiNormalisasi = $maxBobot > 0 ? $bobot / $maxBobot : 0;
                log_message('info', "Normalisasi[$alternatif][$kodeKriteria] = $bobot / max(semua nilai di $kodeKriteria) = $bobot / $maxBobot = $nilaiNormalisasi");
            } else { // cost
                // Untuk cost: Normalisasi[Ai][Cj] = min(Matriks[*][Cj]) / Matriks[Ai][Cj]
                if ($bobot == 0) {
                    // Jika nilai asli 0, berikan nilai normalisasi tertinggi (1)
                    $nilaiNormalisasi = 1;
                    log_message('info', "Normalisasi[$alternatif][$kodeKriteria] = 1 (karena nilai asli = 0)");
                } else {
                    $nilaiNormalisasi = $minBobot / $bobot;
                    log_message('info', "Normalisasi[$alternatif][$kodeKriteria] = min(semua nilai di $kodeKriteria) / $bobot = $minBobot / $bobot = $nilaiNormalisasi");
                }
            }
            
            // Bulatkan ke 4 desimal
            $matrikNormalisasi[$alternatif][$kodeKriteria] = round($nilaiNormalisasi, 2);
        }
        
        log_message('info', "=== Selesai memproses Kriteria $kodeKriteria ===");
    }

    // Siapkan detail perhitungan untuk tampilan
    foreach (array_keys($kriteriaList) as $kodeKriteria) {
        $detailPerhitungan[$kodeKriteria] = [
            'jenis' => $jenisKriteria[$kodeKriteria],
            'max_bobot' => $statsKriteria[$kodeKriteria]['max'],
            'min_bobot' => $statsKriteria[$kodeKriteria]['min'],
            'bobot_asli' => $statsKriteria[$kodeKriteria]['bobot_asli']
        ];
    }

    // Debug hasil akhir
    log_message('info', 'Hasil normalisasi: ' . json_encode($matrikNormalisasi));

    return [
        'matrikNormalisasi' => $matrikNormalisasi,
        'detailPerhitungan' => $detailPerhitungan,
        'jenisKriteria' => $jenisKriteria,
        'kriteriaList' => $kriteriaList,
        'alternatifList' => $alternatifList,
        'matrikAsli' => $matriks,
        'showNormalisasi' => true
    ];
}
}