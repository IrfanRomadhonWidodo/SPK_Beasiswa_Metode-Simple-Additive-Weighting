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

        .modal-content {
            max-height: 90vh;
            overflow-y: auto;
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
                                <th>Kode Alternatif</th>
                                <th>Nama Alternatif</th>
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
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-2xl mx-4 transform transition-all modal-content">
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
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="kode_alternatif" class="block text-sm font-medium text-gray-700 mb-2">Kode Alternatif</label>
                        <input type="text" id="kode_alternatif" name="kode_alternatif" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Contoh: A1" required readonly>
                        <div id="error_kode_alternatif" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>

                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Alternatif</label>
                        <input type="text" id="nama" name="nama" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Contoh: John Doe" required>
                        <div id="error_nama" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="text-md font-semibold text-gray-800 mb-3">Penilaian Kriteria</h4>
                    <div id="kriteriaContainer" class="space-y-4">
                        <!-- Kriteria fields will be loaded here -->
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
        let kriteriaData = [];

        $(document).ready(function() {
            // Initialize DataTable
            table = $('#alternatifTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?= base_url('alternatif/getData') ?>',
                    type: 'POST',
                    dataType: 'json'
                },
                columns: [
                    { data: 'no', orderable: false, searchable: false },
                    { data: 'kode_alternatif' },
                    { data: 'nama' },
                    { 
                        data: 'id',
                        render: function(data) {
                            return `
                                <div class="flex gap-2">
                                    <button onclick="editAlternatif(${data})" class="bg-blue-500 text-white px-2 py-1 rounded text-xs hover:bg-blue-600 transition-colors">
                                        Edit
                                    </button>
                                    <button onclick="deleteAlternatif(${data})" class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600 transition-colors">
                                        Hapus
                                    </button>
                                </div>
                            `;
                        },
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                }
            });

            // Form submission
            $('#alternatifForm').on('submit', function(e) {
                e.preventDefault();
                saveAlternatif();
            });

            // Load kriteria data
            loadKriteriaData();
        });

        function loadKriteriaData() {
            $.ajax({
                url: '<?= base_url('alternatif/getKriteria') ?>',
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        kriteriaData = response.data;
                    }
                }
            });
        }

        function openAddModal() {
            isEdit = false;
            $('#modalTitle').text('Tambah Alternatif');
            $('#submitBtn').text('Simpan');
            $('#alternatifForm')[0].reset();
            $('#alternatifId').val('');
            clearErrors();
            
            // Get next kode alternatif
            $.ajax({
                url: '<?= base_url('alternatif/getNextKode') ?>',
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        $('#kode_alternatif').val(response.kode);
                    }
                }
            });

            loadKriteriaFields();
            $('#alternatifModal').removeClass('hidden').addClass('flex');
        }

        function loadKriteriaFields(nilaiData = null) {
            let container = $('#kriteriaContainer');
            container.empty();

            kriteriaData.forEach(function(kriteria) {
                let selectedValue = '';
                if (nilaiData) {
                    let nilai = nilaiData.find(n => n.kode_kriteria === kriteria.kode_kriteria);
                    if (nilai) {
                        selectedValue = nilai.sub_kriteria_id;
                    }
                }

                let html = `
                    <div class="kriteria-item">
                        <label class="block text-sm font-medium text-gray-700 mb-2">${kriteria.variabel} (${kriteria.kode_kriteria})</label>
                        <select name="kriteria[${kriteria.kode_kriteria}]" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent sub-kriteria-select" data-kriteria="${kriteria.kode_kriteria}" required>
                            <option value="">Pilih ${kriteria.variabel}</option>
                        </select>
                        <div class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                `;
                container.append(html);

                // Load sub kriteria for this kriteria
                loadSubKriteria(kriteria.kode_kriteria, selectedValue);
            });
        }

        function loadSubKriteria(kodeKriteria, selectedValue = '') {
            $.ajax({
                url: `<?= base_url('alternatif/getSubKriteria/') ?>${kodeKriteria}`,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        let select = $(`.sub-kriteria-select[data-kriteria="${kodeKriteria}"]`);
                        select.find('option:not(:first)').remove();
                        
                        response.data.forEach(function(subKriteria) {
                            let selected = selectedValue == subKriteria.id ? 'selected' : '';
                            select.append(`<option value="${subKriteria.id}" ${selected}>${subKriteria.sub_variabel} (Bobot: ${subKriteria.bobot})</option>`);
                        });
                    }
                }
            });
        }

        function closeModal() {
            $('#alternatifModal').removeClass('flex').addClass('hidden');
            clearErrors();
        }

        function clearErrors() {
            $('.text-red-500').addClass('hidden').text('');
            $('.border-red-500').removeClass('border-red-500').addClass('border-gray-300');
        }

        function saveAlternatif() {
            clearErrors();
            
            const formData = new FormData($('#alternatifForm')[0]);
            const url = isEdit ? 
                `<?= base_url('alternatif/update/') ?>${$('#alternatifId').val()}` : 
                '<?= base_url('alternatif/store') ?>';

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        closeModal();
                        table.ajax.reload();
                    } else {
                        if (response.errors) {
                            displayErrors(response.errors);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: response.message
                            });
                        }
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan sistem'
                    });
                }
            });
        }

        function editAlternatif(id) {
            $.ajax({
                url: `<?= base_url('alternatif/show/') ?>${id}`,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        isEdit = true;
                        $('#modalTitle').text('Edit Alternatif');
                        $('#submitBtn').text('Update');
                        $('#alternatifId').val(response.data.id);
                        $('#kode_alternatif').val(response.data.kode_alternatif);
                        $('#nama').val(response.data.nama);
                        
                        loadKriteriaFields(response.data.nilai);
                        $('#alternatifModal').removeClass('hidden').addClass('flex');
                    }
                }
            });
        }

        function deleteAlternatif(id) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus alternatif ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `<?= base_url('alternatif/delete/') ?>${id}`,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Terhapus!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                table.ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: response.message
                                });
                            }
                        }
                    });
                }
            });
        }

        function displayErrors(errors) {
            for (let field in errors) {
                $(`#error_${field}`).removeClass('hidden').text(errors[field]);
                $(`#${field}`).removeClass('border-gray-300').addClass('border-red-500');
            }
        }

        // Close modal when clicking outside
        $('#alternatifModal').on('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>