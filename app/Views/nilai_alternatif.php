<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Data Alternatif</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        /* Custom DataTables Styling */
        .dataTables_wrapper {
            font-family: inherit;
        }
        
        .dataTables_filter input {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.5rem;
            margin-left: 0.5rem;
        }
        
        .dataTables_length select {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.5rem;
            margin: 0 0.5rem;
        }
        
        .dataTables_info, .dataTables_paginate {
            margin-top: 1rem;
        }

        /* Modal Backdrop */
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        /* Custom scrollbar for modal */
        .modal-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .modal-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        .modal-scroll::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }
        .modal-scroll::-webkit-scrollbar-thumb:hover {
            background: #555;
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
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Data Alternatif</h1>
                <p class="text-gray-600">Kelola data alternatif untuk sistem pendukung keputusan</p>
            </div>

            <!-- Card Container -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <!-- Action Button -->
                <div class="mb-4 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">Daftar Alternatif</h2>
                    <button onclick="openAddModal()" class="bg-gradient-main text-white px-4 py-2 rounded-lg hover:opacity-90 transition-opacity flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Alternatif
                    </button>
                </div>

                <!-- DataTable -->
                <div class="overflow-x-auto">
                    <table id="alternatifTable" class="display w-full">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Alternatif</th>
                                <th>Nama</th>
                                <!-- Dynamic kriteria columns will be added here -->
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div id="alternatifModal" class="fixed inset-0 z-50 hidden items-center justify-center modal-backdrop">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-4xl mx-4 transform transition-all max-h-[90vh] overflow-y-auto modal-scroll">
            <div class="flex justify-between items-center mb-4">
                <h3 id="modalTitle" class="text-lg font-semibold text-gray-800">Tambah Alternatif</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="alternatifForm">
                <input type="hidden" id="alternatifId" name="id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="alternatif" class="block text-sm font-medium text-gray-700 mb-2">Kode Alternatif</label>
                        <input type="text" id="alternatif" name="alternatif" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Contoh: A1" required>
                        <div id="error_alternatif" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>

                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Alternatif</label>
                        <input type="text" id="nama" name="nama" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Contoh: John Doe" required>
                        <div id="error_nama" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                </div>

                <!-- Kriteria Section -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Nilai Kriteria</h4>
                    <div id="kriteriaContainer" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Kriteria inputs will be loaded here -->
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="closeModal()" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="submitBtn" class="flex-1 px-4 py-2 bg-gradient-main text-white rounded-lg hover:opacity-90 transition-opacity">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let table;
        let isEdit = false;
        let kriteriaList = [];

        $(document).ready(function() {
            // Load kriteria first, then initialize table
            loadKriteria().then(() => {
                initializeDataTable();
            });

            // Form submission
            $('#alternatifForm').on('submit', function(e) {
                e.preventDefault();
                saveAlternatif();
            });
        });

        function loadKriteria() {
            return $.ajax({
                url: '<?= base_url('alternatif/getKriteria') ?>',
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        kriteriaList = response.data;
                        buildKriteriaInputs();
                    }
                }
            });
        }

        function buildKriteriaInputs() {
            let html = '';
            kriteriaList.forEach(function(kriteria) {
                html += `
                    <div>
                        <label for="kriteria_${kriteria.kode_kriteria}" class="block text-sm font-medium text-gray-700 mb-2">
                            ${kriteria.kode_kriteria} - ${kriteria.variabel}
                        </label>
                        <select id="kriteria_${kriteria.kode_kriteria}" name="kriteria_${kriteria.kode_kriteria}" 
                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">-- Pilih ${kriteria.variabel} --</option>`;
                
                kriteria.sub_kriteria.forEach(function(sub) {
                    html += `<option value="${sub.id}">${sub.sub_variabel} (Bobot: ${sub.bobot})</option>`;
                });
                
                html += `
                        <div id="error_kriteria_${kriteria.kode_kriteria}" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                `;
            });
            $('#kriteriaContainer').html(html);
        }

        function openAddModal() {
            isEdit = false;
            $('#alternatifForm')[0].reset();
            $('#alternatifId').val('');
            clearErrors();
            buildKriteriaInputs();
            $('#modalTitle').text('Tambah Alternatif');
            $('#alternatifModal').removeClass('hidden').addClass('flex');
        }

        function closeModal() {
            $('#alternatifModal').addClass('hidden').removeClass('flex');
        }

        function clearErrors() {
            $('#error_alternatif').addClass('hidden').text('');
            $('#error_nama').addClass('hidden').text('');
            kriteriaList.forEach(function(kriteria) {
                $(`#error_kriteria_${kriteria.kode_kriteria}`).addClass('hidden').text('');
            });
        }

        function initializeDataTable() {
            table = $('#alternatifTable').DataTable({
                ajax: {
                    url: '<?= base_url('alternatif/getData') ?>',
                    type: 'POST',
                    dataSrc: 'data'
                },
                columns: [
                    { data: 'no' },
                    { data: 'alternatif' },
                    { data: 'nama' },
                    // Kriteria columns will be added dynamically
                    { data: 'aksi', orderable: false, searchable: false }
                ],
                destroy: true,
                responsive: true,
                autoWidth: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                },
                initComplete: function(settings, json) {
                    // Add dynamic kriteria columns
                    if (kriteriaList.length > 0 && settings.aoColumns.length === 4) {
                        let columns = [
                            { data: 'no' },
                            { data: 'alternatif' },
                            { data: 'nama' }
                        ];
                        kriteriaList.forEach(function(kriteria) {
                            columns.push({
                                data: `kriteria_${kriteria.kode_kriteria}`,
                                title: `${kriteria.kode_kriteria} - ${kriteria.variabel}`
                            });
                        });
                        columns.push({ data: 'aksi', orderable: false, searchable: false });
                        table.destroy();
                        $('#alternatifTable thead tr').html(`
                            <th>No</th>
                            <th>Alternatif</th>
                            <th>Nama</th>
                            ${kriteriaList.map(k => `<th>${k.kode_kriteria} - ${k.variabel}</th>`).join('')}
                            <th>Aksi</th>
                        `);
                        table = $('#alternatifTable').DataTable({
                            ajax: {
                                url: '<?= base_url('alternatif/getData') ?>',
                                type: 'POST',
                                dataSrc: 'data'
                            },
                            columns: columns,
                            destroy: true,
                            responsive: true,
                            autoWidth: false,
                            language: {
                                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                            }
                        });
                    }
                }
            });
        }

        function saveAlternatif() {
            clearErrors();
            let formData = $('#alternatifForm').serialize();
            let url = isEdit
                ? '<?= base_url('alternatif/update') ?>/' + $('#alternatifId').val()
                : '<?= base_url('alternatif/store') ?>';

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            confirmButtonColor: '#667eea'
                        });
                        closeModal();
                        table.ajax.reload();
                    } else {
                        if (response.errors) {
                            displayErrors(response.errors);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message,
                                confirmButtonColor: '#ef4444'
                            });
                        }
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan sistem',
                        confirmButtonColor: '#ef4444'
                    });
                }
            });
        }

        function displayErrors(errors) {
            if (errors.alternatif) {
                $('#error_alternatif').removeClass('hidden').text(errors.alternatif);
            }
            if (errors.nama) {
                $('#error_nama').removeClass('hidden').text(errors.nama);
            }
            kriteriaList.forEach(function(kriteria) {
                if (errors[`kriteria_${kriteria.kode_kriteria}`]) {
                    $(`#error_kriteria_${kriteria.kode_kriteria}`).removeClass('hidden').text(errors[`kriteria_${kriteria.kode_kriteria}`]);
                }
            });
        }

        function editAlternatif(id) {
            $.ajax({
                url: '<?= base_url('alternatif/show') ?>/' + id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        isEdit = true;
                        $('#alternatifForm')[0].reset();
                        clearErrors();
                        $('#alternatifId').val(response.data.id);
                        $('#alternatif').val(response.data.alternatif);
                        $('#nama').val(response.data.nama);
                        // Set kriteria values
                        kriteriaList.forEach(function(kriteria) {
                            $(`#kriteria_${kriteria.kode_kriteria}`).val(response.data[`kriteria_${kriteria.kode_kriteria}`]);
                        });
                        $('#modalTitle').text('Edit Alternatif');
                        $('#alternatifModal').removeClass('hidden').addClass('flex');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message,
                            confirmButtonColor: '#ef4444'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan sistem',
                        confirmButtonColor: '#ef4444'
                    });
                }
            });
        }

        function deleteAlternatif(id) {
            Swal.fire({
                title: 'Hapus Alternatif?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#667eea',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('alternatif/delete') ?>/' + id,
                        type: 'POST',
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Terhapus!',
                                    text: response.message,
                                    confirmButtonColor: '#667eea'
                                });
                                table.ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message,
                                    confirmButtonColor: '#ef4444'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan sistem',
                                confirmButtonColor: '#ef4444'
                            });
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>
// ...existing code...