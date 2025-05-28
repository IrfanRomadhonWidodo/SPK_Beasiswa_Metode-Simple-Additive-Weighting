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
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
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
            color: #374151;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.2s;
        }
        .dropdown-content a:hover {
            background-color: #f3f4f6;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>
<body class="font-sans bg-gray-100 min-h-screen flex">
    <!-- Sidebar -->
    <div id="sidebar" class="bg-gradient-sidebar text-white w-64 min-h-screen fixed lg:relative z-30 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
        <!-- Logo -->
        <div class="p-6 border-b border-purple-500">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                    <span class="text-purple-600 font-bold text-sm">🎓</span>
                </div>
                <span class="font-bold text-lg">Beasiswa KIP</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="mt-6">
            <div class="px-6">
                <a href="#" class="flex items-center space-x-3 py-3 px-4 rounded-lg bg-purple-600 bg-opacity-50 mb-2">
                    <span class="text-sm">📊</span>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
            </div>

            <!-- Master Data Section -->
            <div class="px-6 mt-6">
                <h3 class="text-xs font-semibold text-purple-200 uppercase tracking-wider mb-3">Master Data</h3>
                
                <a href="#" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-purple-600 hover:bg-opacity-30 transition-colors mb-1">
                    <span class="text-sm">📋</span>
                    <span class="text-sm">Data Kriteria</span>
                </a>
                
                <a href="#" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-purple-600 hover:bg-opacity-30 transition-colors mb-1">
                    <span class="text-sm">📊</span>
                    <span class="text-sm">Data Sub Kriteria</span>
                </a>
                
                <a href="#" class="flex items-center space-x-3 py-3 px-4 rounded-lg bg-purple-600 bg-opacity-30 transition-colors mb-1">
                    <span class="text-sm">🏠</span>
                    <span class="text-sm font-medium">Data Alternatif</span>
                </a>
                
                <a href="#" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-purple-600 hover:bg-opacity-30 transition-colors mb-1">
                    <span class="text-sm">⚖️</span>
                    <span class="text-sm">Data Penilaian</span>
                </a>
                
                <a href="#" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-purple-600 hover:bg-opacity-30 transition-colors mb-1">
                    <span class="text-sm">🧮</span>
                    <span class="text-sm">Data Perhitungan</span>
                </a>
                
                <a href="#" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-purple-600 hover:bg-opacity-30 transition-colors mb-1">
                    <span class="text-sm">📈</span>
                    <span class="text-sm">Data Hasil Akhir</span>
                </a>
            </div>

            <!-- Master User Section -->
            <div class="px-6 mt-6">
                <h3 class="text-xs font-semibold text-purple-200 uppercase tracking-wider mb-3">Master User</h3>
                
                <a href="#" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-purple-600 hover:bg-opacity-30 transition-colors mb-1">
                    <span class="text-sm">👤</span>
                    <span class="text-sm">Data User</span>
                </a>
                
                <a href="#" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-purple-600 hover:bg-opacity-30 transition-colors">
                    <span class="text-sm">👥</span>
                    <span class="text-sm">Data Profile</span>
                </a>
            </div>
        </nav>

        <!-- Collapse Button -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2">
            <button class="w-8 h-8 bg-purple-600 bg-opacity-50 rounded-lg flex items-center justify-center hover:bg-opacity-70 transition-colors">
                <span class="text-sm">‹</span>
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 lg:ml-0">
        <!-- Top Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
                    <span class="block w-6 h-0.5 bg-gray-600 mb-1"></span>
                    <span class="block w-6 h-0.5 bg-gray-600 mb-1"></span>
                    <span class="block w-6 h-0.5 bg-gray-600"></span>
                </button>

                <!-- User Info -->
                <div class="flex items-center space-x-4 ml-auto">
                    <div class="dropdown">
                        <div class="flex items-center space-x-3 cursor-pointer">
                            <div class="text-right">
                                <div class="text-sm font-medium text-gray-800">John Doe</div>
                                <div class="text-xs text-gray-500">Administrator</div>
                            </div>
                            <div class="w-10 h-10 bg-gradient-main rounded-full flex items-center justify-center">
                                <span class="text-white font-medium text-sm">👤</span>
                            </div>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9l6 6 6-6"></path>
                            </svg>
                        </div>
                        <div class="dropdown-content">
                            <a href="#profile" class="flex items-center space-x-2">
                                <span class="text-sm">👤</span>
                                <span>Lihat Profile</span>
                            </a>
                            <a href="#logout" class="flex items-center space-x-2 text-red-600 hover:bg-red-50">
                                <span class="text-sm">🚪</span>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="p-6">
            <!-- Page Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                        <span class="mr-3">🏠</span>
                        Data Alternatif
                    </h1>
                </div>
                <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center space-x-2">
                    <span>+</span>
                    <span>Tambah Data</span>
                </button>
            </div>

            <!-- Data Table Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <!-- Card Header -->
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-purple-600 flex items-center">
                        <span class="mr-2">📋</span>
                        Daftar Data Alternatif
                    </h2>
                </div>

                <!-- Table Controls -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Show</span>
                            <select class="border border-gray-300 rounded px-3 py-1 text-sm">
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                            </select>
                            <span class="text-sm text-gray-600">entries</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Search:</span>
                            <input type="text" class="border border-gray-300 rounded px-3 py-1 text-sm w-48" placeholder="">
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-main text-white">
                                <th class="px-6 py-4 text-left text-sm font-semibold">No</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Nama Alternatif</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <!-- Data akan diisi dari database -->
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer -->
                <div class="p-6 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            Showing 0 to 0 of 0 entries
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="px-3 py-1 text-sm text-gray-500 hover:text-gray-700 disabled:opacity-50" disabled>
                                Previous
                            </button>
                            <button class="px-3 py-1 text-sm bg-purple-500 text-white rounded">
                                1
                            </button>
                            <button class="px-3 py-1 text-sm text-gray-500 hover:text-gray-700 disabled:opacity-50" disabled>
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden hidden"></div>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        });

        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });
    </script>
</body>
</html>