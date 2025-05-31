<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class HalamanController extends BaseController
{
    /**
     * Navigasi ke langkah berikutnya
     */
    public function berikutnya()
    {
        $langkahSekarang = $this->request->getGet('langkah') ?? 1;
        $langkahSekarang = (int) $langkahSekarang;
        
        // Maksimal langkah 3
        $langkahBaru = min($langkahSekarang + 1, 3);
        
        // Redirect kembali ke halaman matriks keputusan dengan langkah baru
        return redirect()->to('/matriks-keputusan?langkah=' . $langkahBaru);
    }
    
    /**
     * Navigasi ke langkah sebelumnya
     */
    public function sebelumnya()
    {
        $langkahSekarang = $this->request->getGet('langkah') ?? 1;
        $langkahSekarang = (int) $langkahSekarang;
        
        // Minimal langkah 1
        $langkahBaru = max($langkahSekarang - 1, 1);
        
        // Redirect kembali ke halaman matriks keputusan dengan langkah baru
        return redirect()->to('/matriks-keputusan?langkah=' . $langkahBaru);
    }
    
    /**
     * Navigasi langsung ke langkah tertentu
     */
    public function goToLangkah($langkah)
    {
        $langkah = (int) $langkah;
        
        // Validasi langkah harus antara 1-3
        if ($langkah < 1 || $langkah > 3) {
            $langkah = 1;
        }
        
        return redirect()->to('/matriks-keputusan?langkah=' . $langkah);
    }
}