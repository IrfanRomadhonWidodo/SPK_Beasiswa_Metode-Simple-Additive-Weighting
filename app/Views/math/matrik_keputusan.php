<!-- LANGKAH PERTAMA -->

<div class="p-4 bg-white min-h-screen max-w-full overflow-hidden">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="bg-gradient-main text-white rounded-lg p-4 shadow-md">
            <h1 class="text-2xl font-bold mb-1">Matriks Keputusan</h1>
            <p class="text-blue-100 text-sm">Sistem Pendukung Keputusan - Metode SAW</p>
        </div>
    </div>

    <!-- Info Card -->
    <div class="mb-4">
        <div class="bg-blue-50 border-l-4 border-blue-400 p-3 rounded-r-lg">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-4 w-4 text-blue-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-2">
                    <h3 class="text-sm font-medium text-blue-800">Informasi Matriks</h3>
                    <p class="mt-1 text-xs text-blue-700">Matriks keputusan berisi nilai bobot dari setiap alternatif terhadap kriteria.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-2 rounded-full bg-green-100 text-green-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600">Total Alternatif</p>
                    <p class="text-lg font-semibold text-gray-900"><?= count($alternatifList) ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-2 rounded-full bg-blue-100 text-blue-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 00-2 2v2a2 2 0 002 2m0 0h14m-14 0a2 2 0 01-2-2V7a2 2 0 012-2h14a2 2 0 012 2v2a2 2 0 01-2 2"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600">Total Kriteria</p>
                    <p class="text-lg font-semibold text-gray-900"><?= count($kriteriaList) ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="p-2 rounded-full bg-purple-100 text-purple-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-medium text-gray-600">Dimensi Matriks</p>
                    <p class="text-lg font-semibold text-gray-900"><?= count($alternatifList) ?>×<?= count($kriteriaList) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Matrix Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                Matriks Keputusan (X)
            </h2>
            <p class="text-xs text-gray-600 mt-1">Nilai bobot setiap alternatif terhadap kriteria</p>
        </div>

        <?php if (!empty($matrikData)): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-purple-100 sticky left-0 z-10">
                            <div class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Alternatif
                            </div>
                        </th>
                        <?php foreach ($kriteriaList as $kodeKriteria => $namaKriteria): ?>
                        <th class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[80px]">
                            <div class="flex flex-col items-center">
                                <span class="font-bold text-purple-600 text-sm"><?= esc($kodeKriteria) ?></span>
                                <span class="text-xs font-normal normal-case text-gray-600 mt-1 leading-tight"><?= esc(substr($namaKriteria, 0, 15)) ?><?= strlen($namaKriteria) > 15 ? '...' : '' ?></span>
                            </div>
                        </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $rowIndex = 0; ?>
                    <?php foreach ($alternatifList as $alternatif): ?>
                    <tr class="<?= $rowIndex % 2 == 0 ? 'bg-white' : 'bg-gray-50' ?> hover:bg-blue-50 transition-colors">
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900 bg-purple-50 sticky left-0 z-10">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-6 w-6 bg-purple-200 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-bold text-purple-800"><?= substr($alternatif, -1) ?></span>
                                </div>
                                <div class="ml-2">
                                    <span class="font-semibold text-sm"><?= esc($alternatif) ?></span>
                                </div>
                            </div>
                        </td>
                        <?php foreach (array_keys($kriteriaList) as $kriteria): ?>
                        <td class="px-2 py-2 whitespace-nowrap text-center">
                            <?php 
                            $nilai = $matrikData[$alternatif][$kriteria] ?? 0;
                            $colorClass = $nilai > 0 ? 'text-green-600 bg-green-50' : 'text-gray-400 bg-gray-50';
                            ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?= $colorClass ?>">
                                <?= number_format($nilai, 2) ?>
                            </span>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    <?php $rowIndex++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-8">
            <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 9a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data</h3>
            <p class="mt-1 text-sm text-gray-500">Belum ada data alternatif dan kriteria yang tersedia.</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Legend -->
    <div class="mt-4">
        <div class="bg-white rounded-lg shadow-sm p-4">
            <h3 class="text-base font-semibold text-gray-900 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Keterangan
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-gray-600">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-green-50 border border-green-200 rounded mr-2"></div>
                    <span>Nilai > 0: Memiliki nilai untuk kriteria</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-gray-50 border border-gray-200 rounded mr-2"></div>
                    <span>Nilai = 0: Tidak memiliki nilai</span>
                </div>
            </div>
            <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                <p class="text-sm text-yellow-800">
                    <strong>Catatan:</strong> Matriks ini akan digunakan untuk perhitungan normalisasi dalam metode SAW.
                </p>
            </div>
        </div>
    </div>
</div>


<!-- LANGKAH KEDUA -->

<?php if (isset($detailPerhitungan) && !empty($detailPerhitungan)): ?>
<!-- Detail Perhitungan Section -->
<div class="mt-6 mb-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-4 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white">
            <h3 class="text-lg font-semibold flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Detail Perhitungan Normalisasi
            </h3>
            <p class="text-emerald-100 text-sm mt-1">Langkah-langkah perhitungan normalisasi untuk setiap kriteria</p>
        </div>

        <!-- Detail per Kriteria -->
        <div class="p-4 space-y-6">
            <?php foreach ($detailPerhitungan as $kodeKriteria => $detail): ?>
            <?php 
                $isBenefit = strtolower($detail['jenis']) === 'benefit';
                $colorClass = $isBenefit ? 'green' : 'red';
                $jenisLabel = strtoupper($detail['jenis']);
            ?>
            
            <!-- Kriteria Individual -->
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <div class="bg-<?= $colorClass ?>-50 px-4 py-3 border-b border-<?= $colorClass ?>-200">
                    <div class="flex items-center justify-between">
                        <h4 class="text-base font-semibold text-<?= $colorClass ?>-800 flex items-center">
                            <span class="bg-<?= $colorClass ?>-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold mr-2">
                                <?= esc($kodeKriteria) ?>
                            </span>
                            <?= esc($kriteriaList[$kodeKriteria]) ?> (<?= $jenisLabel ?>)
                        </h4>
                        <span class="bg-<?= $colorClass ?>-100 text-<?= $colorClass ?>-700 px-2 py-1 rounded text-xs font-medium">
                            <?= $jenisLabel ?>
                        </span>
                    </div>
                </div>
                
                <div class="p-4">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <!-- Formula -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                            <h5 class="text-sm font-semibold text-blue-800 mb-2">Formula yang Digunakan:</h5>
                            <div class="bg-white p-2 rounded border text-center">
                                <?php if ($isBenefit): ?>
                                    <code class="text-blue-700 font-mono">r<sub>ij</sub> = x<sub>ij</sub> / max(x<sub>ij</sub>)</code>
                                <?php else: ?>
                                    <code class="text-blue-700 font-mono">r<sub>ij</sub> = min(x<sub>ij</sub>) / x<sub>ij</sub></code>
                                <?php endif; ?>
                            </div>
                            <div class="mt-2 text-xs text-blue-600">
                                <?php if ($isBenefit): ?>
                                    <p><strong>Max Nilai <?= esc($kodeKriteria) ?>:</strong> <?= number_format($detail['max_bobot'], 2) ?>
                                    <?php 
                                        // Cari alternatif dengan nilai maksimum
                                        $maxAlternatif = array_search($detail['max_bobot'], $detail['bobot_asli']);
                                    ?>
                                    <?php if ($maxAlternatif): ?>
                                        (<?= esc($maxAlternatif) ?>)
                                    <?php endif; ?>
                                    </p>
                                <?php else: ?>
                                    <p><strong>Min Nilai <?= esc($kodeKriteria) ?>:</strong> <?= number_format($detail['min_bobot'], 2) ?>
                                    <?php 
                                        // Cari alternatif dengan nilai minimum (yang > 0)
                                        $bobotNonZero = array_filter($detail['bobot_asli'], function($val) { return $val > 0; });
                                        if (!empty($bobotNonZero)) {
                                            $minAlternatif = array_search(min($bobotNonZero), $detail['bobot_asli']);
                                        }
                                    ?>
                                    <?php if (isset($minAlternatif) && $minAlternatif): ?>
                                        (<?= esc($minAlternatif) ?>)
                                    <?php endif; ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Perhitungan -->
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                            <h5 class="text-sm font-semibold text-gray-800 mb-2">Perhitungan Detail:</h5>
                            <div class="space-y-1 text-xs text-gray-700">
                                <?php foreach ($detail['bobot_asli'] as $alternatif => $bobotAsli): ?>
                                <?php 
                                    if ($isBenefit) {
                                        $nilaiNormalisasi = $detail['max_bobot'] > 0 ? $bobotAsli / $detail['max_bobot'] : 0;
                                        $formula = number_format($bobotAsli, 2) . ' / ' . number_format($detail['max_bobot'], 2);
                                    } else {
                                        if ($bobotAsli == 0) {
                                            $nilaiNormalisasi = 1;
                                            $formula = '1 (nilai 0)';
                                        } else {
                                            $nilaiNormalisasi = $detail['min_bobot'] / $bobotAsli;
                                            $formula = number_format($detail['min_bobot'], 2) . ' / ' . number_format($bobotAsli, 2);
                                        }
                                    }
                                    
                                    // Highlight nilai terbaik
                                    $isOptimal = false;
                                    if ($isBenefit && $bobotAsli == $detail['max_bobot']) {
                                        $isOptimal = true;
                                    } elseif (!$isBenefit && ($bobotAsli == 0 || $bobotAsli == $detail['min_bobot'])) {
                                        $isOptimal = true;
                                    }
                                ?>
                                <div class="flex justify-between <?= $isOptimal ? 'bg-' . $colorClass . '-100 px-2 py-1 rounded' : '' ?>">
                                    <span><?= esc($alternatif) ?>: <?= $formula ?> =</span>
                                    <span class="font-semibold <?= $isOptimal ? 'text-' . $colorClass . '-700' : '' ?>">
                                        <?= number_format($nilaiNormalisasi, 2) ?>
                                    </span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Keterangan Khusus untuk Cost -->
                    <?php if (!$isBenefit): ?>
                    <div class="mt-3 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                        <div class="flex items-start">
                            <svg class="h-4 w-4 text-yellow-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="text-xs text-yellow-800">
                                <strong>Catatan Cost:</strong> Semakin kecil nilai asli, semakin baik (mendapat nilai normalisasi tinggi). Nilai 0 dianggap optimal dan mendapat normalisasi 1.
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Summary -->
        <div class="px-4 pb-4">
            <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-3">
                <div class="flex items-start">
                    <svg class="h-4 w-4 text-emerald-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="text-sm text-emerald-800">
                        <strong>Ringkasan:</strong> Setiap kriteria dinormalisasi menggunakan formula yang sesuai dengan jenisnya. 
                        Kriteria <strong>Benefit</strong> menggunakan pembagian dengan nilai maksimum, sedangkan kriteria <strong>Cost</strong> 
                        menggunakan pembagian nilai minimum dengan nilai aktual. Hasil normalisasi berkisar antara 0-1.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>




<!-- LANGKAH KETIGA -->

<?php if (isset($showNormalisasi) && $showNormalisasi): ?>
<!-- Normalization Section -->
<div class="mt-8 p-4 bg-white min-h-screen max-w-full overflow-hidden">
    <!-- Section Header -->
    <div class="mb-6">
        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-lg p-4 shadow-md">
            <h2 class="text-2xl font-bold mb-1">Matriks Ternormalisasi</h2>
            <p class="text-emerald-100 text-sm">Hasil Normalisasi Menggunakan Metode SAW</p>
        </div>
    </div>

    <!-- Normalization Info Card -->
    <div class="mb-4">
        <div class="bg-emerald-50 border-l-4 border-emerald-400 p-3 rounded-r-lg">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-4 w-4 text-emerald-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-2">
                    <h3 class="text-sm font-medium text-emerald-800">Formula Normalisasi SAW</h3>
                    <div class="mt-2 text-xs text-emerald-700 space-y-1">
                        <div class="bg-white p-2 rounded border">
                            <strong>Benefit:</strong> r<sub>ij</sub> = x<sub>ij</sub> / max(x<sub>ij</sub>)
                        </div>
                        <div class="bg-white p-2 rounded border">
                            <strong>Cost:</strong> r<sub>ij</sub> = min(x<sub>ij</sub>) / x<sub>ij</sub>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Normalized Matrix Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                Matriks Ternormalisasi (R)
            </h3>
            <p class="text-xs text-gray-600 mt-1">Hasil normalisasi dengan formula SAW (nilai 0-1)</p>
        </div>

        <?php if (!empty($matrikNormalisasi)): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-emerald-100 sticky left-0 z-10">
                            <div class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Alternatif
                            </div>
                        </th>
                        <?php foreach ($kriteriaList as $kodeKriteria => $namaKriteria): ?>
                        <th class="px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[80px]">
                            <div class="flex flex-col items-center">
                                <span class="font-bold text-emerald-600 text-sm"><?= esc($kodeKriteria) ?></span>
                                <span class="text-xs font-normal normal-case text-gray-600 mt-1 leading-tight">
                                    <?= esc(substr($namaKriteria, 0, 12)) ?><?= strlen($namaKriteria) > 12 ? '...' : '' ?>
                                </span>
                                <?php if (isset($jenisKriteria[$kodeKriteria])): ?>
                                <span class="mt-1 px-1 py-0.5 text-xs rounded <?= $jenisKriteria[$kodeKriteria] === 'benefit' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                                    <?= ucfirst($jenisKriteria[$kodeKriteria]) ?>
                                </span>
                                <?php endif; ?>
                            </div>
                        </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $rowIndex = 0; ?>
                    <?php foreach ($alternatifList as $alternatif): ?>
                    <tr class="<?= $rowIndex % 2 == 0 ? 'bg-white' : 'bg-gray-50' ?> hover:bg-emerald-50 transition-colors">
                        <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900 bg-emerald-50 sticky left-0 z-10">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-6 w-6 bg-emerald-200 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-bold text-emerald-800"><?= substr($alternatif, -1) ?></span>
                                </div>
                                <div class="ml-2">
                                    <span class="font-semibold text-sm"><?= esc($alternatif) ?></span>
                                </div>
                            </div>
                        </td>
                        <?php foreach (array_keys($kriteriaList) as $kriteria): ?>
                        <td class="px-2 py-2 whitespace-nowrap text-center">
                            <?php 
                            $nilaiNormalisasi = $matrikNormalisasi[$alternatif][$kriteria] ?? 0;
                            
                            // Tentukan warna berdasarkan nilai (0-1 scale)
                            if ($nilaiNormalisasi == 1) {
                                $colorClass = 'text-green-700 bg-green-100 border-green-300';
                            } elseif ($nilaiNormalisasi >= 0.75) {
                                $colorClass = 'text-blue-700 bg-blue-100 border-blue-300';
                            } elseif ($nilaiNormalisasi >= 0.5) {
                                $colorClass = 'text-yellow-700 bg-yellow-100 border-yellow-300';
                            } elseif ($nilaiNormalisasi > 0) {
                                $colorClass = 'text-orange-700 bg-orange-100 border-orange-300';
                            } else {
                                $colorClass = 'text-gray-500 bg-gray-100 border-gray-300';
                            }
                            ?>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border <?= $colorClass ?>">
                                <?= number_format($nilaiNormalisasi, 2) ?>
                            </span>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    <?php $rowIndex++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-8">
            <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 9a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data normalisasi</h3>
            <p class="mt-1 text-sm text-gray-500">Belum ada data yang dapat dinormalisasi.</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Normalization Legend -->
    <div class="mt-4">
        <div class="bg-white rounded-lg shadow-sm p-4">
            <h4 class="text-base font-semibold text-gray-900 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Keterangan
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <h5 class="font-medium text-gray-800 mb-2">Interpretasi Nilai:</h5>
                    <div class="space-y-1">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-100 border border-green-300 rounded mr-2"></div>
                            <span>1.00: Nilai Optimal (Terbaik)</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-100 border border-blue-300 rounded mr-2"></div>
                            <span>0.75 - 0.99: Sangat Baik</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-100 border border-yellow-300 rounded mr-2"></div>
                            <span>0.50 - 0.74: Baik</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-orange-100 border border-orange-300 rounded mr-2"></div>
                            <span>0.01 - 0.49: Cukup</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-gray-100 border border-gray-300 rounded mr-2"></div>
                            <span>0.00: Tidak Ada Nilai</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 p-3 bg-emerald-50 border border-emerald-200 rounded-lg">
                <p class="text-sm text-emerald-800">
                    <strong>Keterangan:</strong> Matriks ternormalisasi menghasilkan nilai dalam rentang 0-1. 
                    Nilai ini akan dikalikan dengan bobot preferensi (W) untuk mendapatkan skor akhir dalam perhitungan SAW.
                </p>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


<style>
    .bg-gradient-main {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    /* Responsive table scrolling */
    .overflow-x-auto {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 #f7fafc;
    }
    
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f7fafc;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 3px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #a0aec0;
    }
</style>