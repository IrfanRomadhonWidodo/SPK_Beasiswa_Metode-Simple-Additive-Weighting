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
            gap: 0.5rem; /* space-x-2 */
            padding: 0.5rem 0.75rem; /* py-2 px-3 */
            font-size: 0.875rem; /* text-sm */
            color: #374151;
            text-align: left;
            width: 100%;
            transition: background-color 0.2s;
            text-decoration: none;
        }
        .dropdown-content a:hover {
            background-color: #f9fafb; /* hover:bg-gray-50 */
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>
<body class="font-sans bg-gray-100 min-h-screen flex">
    <!-- Sidebar Include -->
    <?= view('layout/sidebar') ?>

    <!-- Main Content -->
    <div class="flex-1 lg:ml-0">
    <!-- Navbar Include -->
    <?= view('layout/navbar') ?>

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