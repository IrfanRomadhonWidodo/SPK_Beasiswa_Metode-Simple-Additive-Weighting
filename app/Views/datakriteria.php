<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Beasiswa KIP</title>
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
    
    <!-- Main Content -->
    <div class="flex-1 lg:ml-64">
        <!-- Navbar Include -->
        <?= view('layout/navbar') ?>
        
        <!-- Page Content -->
        <div class="p-6">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Data Kriteria</h1>
                <p class="text-gray-600">Kelola data kriteria untuk sistem pendukung keputusan</p>
            </div>

            <!-- Card Container -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <!-- Action Button -->
                <div class="mb-4 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">Daftar Kriteria</h2>
                    <button onclick="openAddModal()" class="bg-gradient-main text-white px-4 py-2 rounded-lg hover:opacity-90 transition-opacity flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Kriteria
                    </button>
                </div>

                <!-- DataTable -->
                <div class="overflow-x-auto">
                    <table id="kriteriaTable" class="display w-full">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Kriteria</th>
                                <th>Variabel</th>
                                <th>Jenis Kriteria</th>
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
    <div id="kriteriaModal" class="fixed inset-0 z-50 hidden items-center justify-center modal-backdrop">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4 transform transition-all">
            <div class="flex justify-between items-center mb-4">
                <h3 id="modalTitle" class="text-lg font-semibold text-gray-800">Tambah Kriteria</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="kriteriaForm">
                <input type="hidden" id="kriteriaId" name="id">
                
                <div class="mb-4">
                    <label for="kode_kriteria" class="block text-sm font-medium text-gray-700 mb-2">Kode Kriteria</label>
                    <input type="text" id="kode_kriteria" name="kode_kriteria" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Contoh: C1" required>
                    <div id="error_kode_kriteria" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>

                <div class="mb-4">
                    <label for="variabel" class="block text-sm font-medium text-gray-700 mb-2">Variabel</label>
                    <input type="text" id="variabel" name="variabel" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Contoh: Nilai Akademik" required>
                    <div id="error_variabel" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>

                <div class="mb-6">
                    <label for="jenis_kriteria" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kriteria</label>
                    <select id="jenis_kriteria" name="jenis_kriteria" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                        <option value="">Pilih Jenis Kriteria</option>
                        <option value="Benefit">Benefit (Semakin tinggi semakin baik)</option>
                        <option value="Cost">Cost (Semakin rendah semakin baik)</option>
                    </select>
                    <div id="error_jenis_kriteria" class="text-red-500 text-sm mt-1 hidden"></div>
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

        $(document).ready(function() {
            // Initialize DataTable
            table = $('#kriteriaTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?= base_url('kriteria/getData') ?>',
                    type: 'POST',
                    dataType: 'json'
                },
                columns: [
                    { data: 'no', orderable: false, searchable: false },
                    { data: 'kode_kriteria' },
                    { data: 'variabel' },
                    { 
                        data: 'jenis_kriteria',
                        render: function(data) {
                            let badgeClass = data === 'Benefit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                            return `<span class="px-2 py-1 rounded-full text-xs font-medium ${badgeClass}">${data}</span>`;
                        }
                    },
                    { 
                        data: 'id',
                        render: function(data) {
                            return `
                                <div class="flex gap-2">
                                    <button onclick="editKriteria(${data})" class="bg-blue-500 text-white px-2 py-1 rounded text-xs hover:bg-blue-600 transition-colors">
                                        Edit
                                    </button>
                                    <button onclick="deleteKriteria(${data})" class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600 transition-colors">
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
            $('#kriteriaForm').on('submit', function(e) {
                e.preventDefault();
                saveKriteria();
            });
        });

        function openAddModal() {
            isEdit = false;
            $('#modalTitle').text('Tambah Kriteria');
            $('#submitBtn').text('Simpan');
            $('#kriteriaForm')[0].reset();
            $('#kriteriaId').val('');
            clearErrors();
            $('#kriteriaModal').removeClass('hidden').addClass('flex');
        }

        function closeModal() {
            $('#kriteriaModal').removeClass('flex').addClass('hidden');
            clearErrors();
        }

        function clearErrors() {
            $('.text-red-500').addClass('hidden').text('');
            $('.border-red-500').removeClass('border-red-500').addClass('border-gray-300');
        }

        function saveKriteria() {
            clearErrors();
            
            const formData = new FormData($('#kriteriaForm')[0]);
            const url = isEdit ? 
                `<?= base_url('kriteria/update/') ?>${$('#kriteriaId').val()}` : 
                '<?= base_url('kriteria/store') ?>';

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

        function editKriteria(id) {
            $.ajax({
                url: `<?= base_url('kriteria/show/') ?>${id}`,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        isEdit = true;
                        $('#modalTitle').text('Edit Kriteria');
                        $('#submitBtn').text('Update');
                        $('#kriteriaId').val(response.data.id);
                        $('#kode_kriteria').val(response.data.kode_kriteria);
                        $('#variabel').val(response.data.variabel);
                        $('#jenis_kriteria').val(response.data.jenis_kriteria);
                        $('#kriteriaModal').removeClass('hidden').addClass('flex');
                    }
                }
            });
        }

        function deleteKriteria(id) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus kriteria ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `<?= base_url('kriteria/delete/') ?>${id}`,
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
        $('#kriteriaModal').on('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>