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