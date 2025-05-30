<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Normalisasi Matriks</h1>
        <p class="text-gray-600">Proses normalisasi menggunakan metode SAW (Simple Additive Weighting)</p>
    </div>

    <!-- Action Buttons -->
    <div class="mb-6 flex flex-wrap gap-3">
        <button 
            onclick="prosesNormalisasi()" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-sm transition duration-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Proses Normalisasi
        </button>
        
        <?php if ($hasData): ?>
        <button 
            onclick="resetData()" 
            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg shadow-sm transition duration-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            Reset Data
        </button>
        <?php endif; ?>
    </div>

    <!-- Loading Indicator -->
    <div id="loadingIndicator" class="hidden">
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
            <div class="flex items-center">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600 mr-3"></div>
                <p class="text-blue-700">Memproses normalisasi...</p>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <div id="alertMessage" class="hidden mb-6"></div>

    <?php if ($hasData): ?>
    <!-- Results Table -->
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b">
            <h2 class="text-xl font-semibold text-gray-800">Hasil Normalisasi Matriks</h2>
            <p class="text-sm text-gray-600 mt-1">Matriks ternormalisasi untuk perhitungan SAW</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                            Alternatif
                        </th>
                        <?php foreach ($kriteriaList as $kodeKriteria): ?>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <?= $kodeKriteria ?>
                        </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($alternatifList as $kodeAlternatif): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white">
                            <?= $kodeAlternatif ?>
                        </td>
                        <?php foreach ($kriteriaList as $kodeKriteria): ?>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <?php if (isset($matrikData[$kodeAlternatif][$kodeKriteria])): ?>
                                <?php $data = $matrikData[$kodeAlternatif][$kodeKriteria]; ?>
                                <div class="space-y-1">
                                    <div class="text-sm font-semibold text-gray-900">
                                        <?= number_format($data['hasil_normalisasi'], 4) ?>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        (<?= $data['nilai_asli'] ?>)
                                    </div>
                                    <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?= $data['jenis_kriteria'] === 'benefit' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' ?>">
                                        <?= ucfirst($data['jenis_kriteria']) ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <span class="text-gray-400">-</span>
                            <?php endif; ?>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Formula Information -->
    <div class="mt-6 bg-blue-50 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-3">Rumus Normalisasi</h3>
        <div class="grid md:grid-cols-2 gap-4">
            <div class="bg-white rounded-lg p-4 border border-blue-200">
                <h4 class="font-semibold text-green-800 mb-2">Kriteria Benefit (Keuntungan)</h4>
                <div class="text-sm text-gray-700">
                    <code class="bg-gray-100 px-2 py-1 rounded">R<sub>ij</sub> = X<sub>ij</sub> / Max(X<sub>ij</sub>)</code>
                    <p class="mt-2">Nilai terbesar adalah yang terbaik</p>
                </div>
            </div>
            <div class="bg-white rounded-lg p-4 border border-blue-200">
                <h4 class="font-semibold text-orange-800 mb-2">Kriteria Cost (Biaya)</h4>
                <div class="text-sm text-gray-700">
                    <code class="bg-gray-100 px-2 py-1 rounded">R<sub>ij</sub> = Min(X<sub>ij</sub>) / X<sub>ij</sub></code>
                    <p class="mt-2">Nilai terkecil adalah yang terbaik</p>
                </div>
            </div>
        </div>
    </div>

    <?php else: ?>
    <!-- No Data State -->
    <div class="bg-gray-50 rounded-lg p-12 text-center">
        <div class="w-16 h-16 mx-auto mb-4 text-gray-400">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum Ada Data Normalisasi</h3>
        <p class="text-gray-600 mb-6">Klik tombol "Proses Normalisasi" untuk memulai perhitungan normalisasi matriks</p>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-left">
            <h4 class="font-semibold text-yellow-800 mb-2">Persyaratan:</h4>
            <ul class="text-sm text-yellow-700 space-y-1">
                <li>• Data kriteria harus sudah tersedia dengan jenis kriteria (benefit/cost)</li>
                <li>• Data alternatif nilai harus sudah terisi</li>
                <li>• Pastikan matriks keputusan sudah terbentuk</li>
            </ul>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
function prosesNormalisasi() {
    const loadingIndicator = document.getElementById('loadingIndicator');
    const alertMessage = document.getElementById('alertMessage');
    
    // Show loading
    loadingIndicator.classList.remove('hidden');
    alertMessage.classList.add('hidden');
    
    fetch('<?= base_url('math/normalisasi_matrik/proses') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        loadingIndicator.classList.add('hidden');
        
        if (data.success) {
            showAlert('success', data.message + ` (${data.data_count} data berhasil diproses)`);
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showAlert('error', data.message);
        }
    })
    .catch(error => {
        loadingIndicator.classList.add('hidden');
        showAlert('error', 'Terjadi kesalahan: ' + error.message);
    });
}

function resetData() {
    if (!confirm('Apakah Anda yakin ingin menghapus semua data normalisasi?')) {
        return;
    }
    
    const alertMessage = document.getElementById('alertMessage');
    
    fetch('<?= base_url('math/normalisasi_matrik/reset') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showAlert('error', data.message);
        }
    })
    .catch(error => {
        showAlert('error', 'Terjadi kesalahan: ' + error.message);
    });
}

function showAlert(type, message) {
    const alertMessage = document.getElementById('alertMessage');
    const alertClass = type === 'success' ? 'bg-green-50 border-green-500 text-green-700' : 'bg-red-50 border-red-500 text-red-700';
    const iconPath = type === 'success' 
        ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
        : 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z';
    
    alertMessage.innerHTML = `
        <div class="${alertClass} border-l-4 p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${iconPath}"></path>
                </svg>
                <p>${message}</p>
            </div>
        </div>
    `;
    
    alertMessage.classList.remove('hidden');
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        alertMessage.classList.add('hidden');
    }, 5000);
}
</script>