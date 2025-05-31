<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Beasiswa KIP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'purple-start': '#667eea',
                        'purple-mid': '#764ba2',
                        'purple-end': '#f093fb',
                        'sidebar-purple': '#7c3aed',
                    }
                }
            }
        }
    </script>
    <style>
        .bg-gradient-sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .bg-gradient-main {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        .dropdown-content a {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            color: #374151;
            text-align: left;
            width: 100%;
            transition: background-color 0.2s;
            text-decoration: none;
        }
        .dropdown-content a:hover {
            background-color: #f9fafb;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Custom scrollbar */
        .overflow-x-auto {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }
        
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f7fafc;
            border-radius: 4px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 4px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Ranking animation */
        .ranking-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .ranking-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        /* Table responsive fixes */
        .table-container {
            max-width: 100%;
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        
        .compact-table {
            font-size: 0.75rem;
        }
        
        .compact-table th {
            padding: 0.5rem 0.25rem;
            min-width: 80px;
            max-width: 100px;
        }
        
        .compact-table td {
            padding: 0.5rem 0.25rem;
            max-width: 100px;
        }
        
        .sticky-col {
            position: sticky;
            left: 0;
            z-index: 10;
            background: white;
            border-right: 2px solid #e5e7eb;
        }
        
        .total-col {
            position: sticky;
            right: 0;
            z-index: 10;
            background: #eff6ff;
            border-left: 2px solid #ddd6fe;
        }

        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .compact-table {
                font-size: 0.7rem;
            }
            
            .compact-table th,
            .compact-table td {
                min-width: 70px;
                max-width: 80px;
                padding: 0.375rem 0.25rem;
            }
        }
        #sidebar::-webkit-scrollbar {
        display: none; /* untuk Chrome, Safari, Opera */
        }

        #sidebar {
            -ms-overflow-style: none;  /* untuk IE dan Edge */
            scrollbar-width: none;     /* untuk Firefox */
        }
    </style>
</head>
<body class="font-sans bg-gray-100 min-h-screen flex">
    <!-- Sidebar Include -->
    <?= view('layout/sidebar') ?>
    <div class="flex-1 lg:ml-64">
        <!-- Navbar Include -->
        <?= view('layout/navbar') ?>
    <!-- Main Content with better width management -->
    <div class="flex-1 p-4 bg-white min-h-screen overflow-hidden">
        <!-- Header Section -->
        <div class="mb-6">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg p-4 shadow-md">
                <h1 class="text-xl lg:text-2xl font-bold mb-1">Perangkingan Preferensi</h1>
                <p class="text-indigo-100 text-sm">Hasil Akhir Perhitungan Metode SAW</p>
            </div>
        </div>

        <!-- Info Card - Made more compact -->
        <div class="mb-4">
            <div class="bg-indigo-50 border-l-4 border-indigo-400 p-3 rounded-r-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-4 w-4 text-indigo-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-2">
                        <h3 class="text-sm font-medium text-indigo-800">Formula Perhitungan</h3>
                        <div class="mt-2 text-xs text-indigo-700">
                            <div class="bg-white p-2 rounded border text-xs">
                                <strong>V<sub>i</sub></strong> = Σ(R<sub>ij</sub> × W<sub>j</sub>) dimana:
                                <br>• V<sub>i</sub> = Nilai preferensi alternatif ke-i
                                <br>• R<sub>ij</sub> = Nilai normalisasi alternatif ke-i pada kriteria ke-j
                                <br>• W<sub>j</sub> = Bobot preferensi kriteria ke-j
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ranking Results -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                <!-- Bar kiri (pendek) -->
                <rect x="3" y="14" width="4" height="7" rx="1"></rect>
                <!-- Bar tengah (sedang) -->
                <rect x="10" y="10" width="4" height="11" rx="1"></rect>
                <!-- Bar kanan (tinggi) -->
                <rect x="17" y="6" width="4" height="15" rx="1"></rect>
                </svg>
                    Peringkat Alternatif
                </h2>
                <p class="text-xs text-gray-600 mt-1">Hasil perangkingan berdasarkan nilai preferensi tertinggi</p>
            </div>

            <?php if (!empty($peringkat)): ?>
            <div class="p-4">
                <div class="space-y-3">
                    <?php foreach ($peringkat as $index => $rank): ?>
                    <?php 
                        // Tentukan styling berdasarkan peringkat
                        if ($rank['rank'] == 1) {
                            $bgClass = 'bg-gradient-to-r from-yellow-400 to-yellow-500';
                            $textClass = 'text-yellow-900';
                            $iconClass = 'text-yellow-700';
                            $medalIcon = '🥇';
                        } elseif ($rank['rank'] == 2) {
                            $bgClass = 'bg-gradient-to-r from-gray-300 to-gray-400';
                            $textClass = 'text-gray-900';
                            $iconClass = 'text-gray-700';
                            $medalIcon = '🥈';
                        } elseif ($rank['rank'] == 3) {
                            $bgClass = 'bg-gradient-to-r from-orange-400 to-orange-500';
                            $textClass = 'text-orange-900';
                            $iconClass = 'text-orange-700';
                            $medalIcon = '🥉';
                        } else {
                            $bgClass = 'bg-gradient-to-r from-blue-50 to-indigo-50';
                            $textClass = 'text-gray-900';
                            $iconClass = 'text-indigo-600';
                            $medalIcon = '';
                        }
                    ?>
                    <div class="<?= $bgClass ?> rounded-lg p-3 lg:p-4 shadow-sm border <?= $rank['rank'] <= 3 ? 'border-2 border-opacity-30' : '' ?> ranking-card">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3 lg:space-x-4">
                                <div class="flex items-center space-x-2">
                                    <div class="flex-shrink-0 h-8 w-8 lg:h-10 lg:w-10 bg-white bg-opacity-80 rounded-full flex items-center justify-center <?= $rank['rank'] <= 3 ? 'ring-2 ring-white ring-opacity-50' : '' ?>">
                                        <span class="text-sm lg:text-lg font-bold <?= $iconClass ?>"><?= $rank['rank'] ?></span>
                                    </div>
                                    <?php if ($medalIcon): ?>
                                    <span class="text-xl lg:text-2xl"><?= $medalIcon ?></span>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h3 class="text-base lg:text-lg font-semibold <?= $textClass ?>"><?= esc($rank['alternatif']) ?></h3>
                                    <p class="text-xs lg:text-sm <?= $textClass ?> opacity-80">Alternatif <?= substr($rank['alternatif'], -1) ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-lg lg:text-2xl font-bold <?= $textClass ?>"><?= number_format($rank['nilai_preferensi'], 4) ?></div>
                                <div class="text-xs <?= $textClass ?> opacity-80">Nilai Preferensi</div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php else: ?>
            <!-- Empty State -->
            <div class="text-center py-8">
                <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 9a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data peringkat</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada data yang dapat diperingkat.</p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Detail Calculation Table - Redesigned for better responsiveness -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                    Detail Perhitungan Preferensi
                </h3>
                <p class="text-xs text-gray-600 mt-1">Tabel detail perhitungan nilai preferensi per alternatif dan kriteria</p>
            </div>

            <?php if (!empty($detailPerhitungan)): ?>
            <div class="table-container">
                <table class="min-w-full divide-y divide-gray-200 compact-table">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="sticky-col px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-purple-100">
                                <div class="flex flex-col items-start">
                                    <div class="flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span class="text-xs">Alternatif</span>
                                    </div>
                                </div>
                            </th>
                            <?php foreach ($kriteriaList as $kodeKriteria => $namaKriteria): ?>
                            <th class="px-1 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex flex-col items-center space-y-1">
                                    <span class="font-bold text-purple-600 text-xs"><?= esc($kodeKriteria) ?></span>
                                    <span class="text-xs font-normal normal-case text-gray-600 leading-tight">
                                        <?= esc(substr($namaKriteria, 0, 8)) ?><?= strlen($namaKriteria) > 8 ? '...' : '' ?>
                                    </span>
                                    <?php if (isset($bobotKriteria[$kodeKriteria])): ?>
                                    <span class="px-1 py-0.5 text-xs bg-purple-100 text-purple-700 rounded">
                                        W:<?= number_format($bobotKriteria[$kodeKriteria]['bobot_preferensi'], 2) ?>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </th>
                            <?php endforeach; ?>
                            <th class="total-col px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex flex-col items-center">
                                    <span class="font-bold text-indigo-600 text-xs">Total</span>
                                    <span class="text-xs text-gray-600">Nilai Preferensi</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $rowIndex = 0; ?>
                        <?php foreach ($alternatifList as $alternatif): ?>
                        <tr class="<?= $rowIndex % 2 == 0 ? 'bg-white' : 'bg-gray-50' ?> hover:bg-purple-50 transition-colors">
                            <td class="sticky-col px-2 py-2 whitespace-nowrap text-xs font-medium text-gray-900 bg-purple-50">
                                <div class="flex items-center space-x-2">
                                    <div class="flex-shrink-0 h-5 w-5 bg-purple-200 rounded-full flex items-center justify-center">
                                        <span class="text-xs font-bold text-purple-800"><?= substr($alternatif, -1) ?></span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <span class="font-semibold text-xs truncate block"><?= esc($alternatif) ?></span>
                                    </div>
                                </div>
                            </td>
                            <?php foreach (array_keys($kriteriaList) as $kriteria): ?>
                            <td class="px-1 py-2 whitespace-nowrap text-center">
                                <?php 
                                $detail = $detailPerhitungan[$alternatif]['detail'][$kriteria] ?? null;
                                if ($detail): 
                                ?>
                                <div class="text-xs space-y-0.5">
                                    <div class="text-gray-600">R:<?= number_format($detail['normalisasi'], 3) ?></div>
                                    <div class="text-gray-600">W:<?= number_format($detail['bobot_preferensi'], 2) ?></div>
                                    <div class="border-t pt-0.5">
                                        <span class="font-medium text-purple-700 text-xs">
                                            <?= number_format($detail['kontribusi'], 3) ?>
                                        </span>
                                    </div>
                                </div>
                                <?php else: ?>
                                <span class="text-gray-400">-</span>
                                <?php endif; ?>
                            </td>
                            <?php endforeach; ?>
                            <td class="total-col px-2 py-2 whitespace-nowrap text-center">
                                <div class="flex flex-col items-center">
                                    <span class="text-sm font-bold text-indigo-700">
                                        <?= number_format($nilaiPreferensi[$alternatif] ?? 0, 4) ?>
                                    </span>
                                    <?php 
                                    // Cari peringkat alternatif ini
                                    $currentRank = 0;
                                    foreach ($peringkat as $rank) {
                                        if ($rank['alternatif'] == $alternatif) {
                                            $currentRank = $rank['rank'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <span class="text-xs text-indigo-600 mt-0.5">
                                        #<?= $currentRank ?>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <?php $rowIndex++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>

        <!-- Summary & Legend - Made more compact -->
        <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Summary -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <h4 class="text-base font-semibold text-gray-900 mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2-2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Ringkasan Hasil
                </h4>
                <?php if (!empty($peringkat)): ?>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Alternatif Terbaik:</span>
                        <span class="font-semibold text-green-600"><?= esc($peringkat[0]['alternatif']) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nilai Tertinggi:</span>
                        <span class="font-semibold"><?= number_format($peringkat[0]['nilai_preferensi'], 4) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Alternatif:</span>
                        <span class="font-semibold"><?= count($peringkat) ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Kriteria Digunakan:</span>
                        <span class="font-semibold"><?= count($kriteriaList) ?></span>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Legend -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <h4 class="text-base font-semibold text-gray-900 mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Keterangan
                </h4>
                <div class="space-y-2 text-sm text-gray-600">
                    <div><strong>R:</strong> Nilai hasil normalisasi (0-1)</div>
                    <div><strong>W:</strong> Bobot preferensi kriteria</div>
                    <div><strong>Kontribusi:</strong> R × W untuk setiap kriteria</div>
                    <div><strong>Total:</strong> Penjumlahan semua kontribusi</div>
                </div>
                <div class="mt-3 p-3 bg-indigo-50 border border-indigo-200 rounded-lg">
                    <p class="text-sm text-indigo-800">
                        <strong>Kesimpulan:</strong> Alternatif dengan nilai preferensi tertinggi merupakan pilihan terbaik berdasarkan metode SAW.
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>