<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Beasiswa KIP</title>
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
        .form-input:focus {
            outline: none;
            ring: 2px;
            ring-color: #667eea;
            border-color: #667eea;
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

        <!-- Profile Content -->
        <div class="p-6">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Profile Settings</h1>
                <p class="text-gray-600">Kelola informasi profil dan keamanan akun Anda</p>
            </div>

            <!-- Success/Error Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                    <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                    <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Profile Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="text-center">
                            <!-- Profile Avatar -->
                            <div class="mx-auto w-32 h-32 bg-gradient-main rounded-full flex items-center justify-center mb-4">
                                <span class="text-4xl font-bold text-white">
                                    <?= strtoupper(substr($user['full_name'] ?? $user['username'], 0, 1)) ?>
                                </span>
                            </div>
                            
                            <h2 class="text-xl font-semibold text-gray-800 mb-1">
                                <?= esc($user['full_name'] ?? 'Nama Lengkap') ?>
                            </h2>
                            <p class="text-gray-600 mb-2">@<?= esc($user['username']) ?></p>
                            <p class="text-sm text-gray-500 mb-4"><?= esc($user['email']) ?></p>
                            
                            <!-- Status Badge -->
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?= $user['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                <?= $user['is_active'] ? 'Active' : 'Inactive' ?>
                            </span>
                            
                            <!-- Account Info -->
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="text-sm text-gray-600">
                                    <p class="mb-1">
                                        <span class="font-medium">Bergabung:</span>
                                        <?= date('d M Y', strtotime($user['created_at'])) ?>
                                    </p>
                                    <p>
                                        <span class="font-medium">Update Terakhir:</span>
                                        <?= date('d M Y', strtotime($user['updated_at'])) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md">
                        <!-- Tab Navigation -->
                        <div class="border-b border-gray-200">
                            <nav class="flex">
                                <button id="tab-profile" class="tab-button active px-6 py-3 border-b-2 border-purple-start text-purple-start font-medium">
                                    Informasi Profil
                                </button>
                                <button id="tab-security" class="tab-button px-6 py-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium">
                                    Keamanan
                                </button>
                            </nav>
                        </div>

                        <!-- Profile Tab Content -->
                        <div id="content-profile" class="tab-content p-6">
                            <form method="POST" action="<?= base_url('profile/update') ?>">
                                <?= csrf_field() ?>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Username -->
                                    <div>
                                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                                        <input type="text" id="username" name="username" 
                                               value="<?= esc($user['username']) ?>"
                                               class="form-input w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-purple-start focus:border-purple-start"
                                               required>
                                        <?php if (isset($validation) && $validation->hasError('username')): ?>
                                            <p class="mt-1 text-sm text-red-600"><?= $validation->getError('username') ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Full Name -->
                                    <div>
                                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                        <input type="text" id="full_name" name="full_name" 
                                               value="<?= esc($user['full_name']) ?>"
                                               class="form-input w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-purple-start focus:border-purple-start">
                                        <?php if (isset($validation) && $validation->hasError('full_name')): ?>
                                            <p class="mt-1 text-sm text-red-600"><?= $validation->getError('full_name') ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Email -->
                                    <div class="md:col-span-2">
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <input type="email" id="email" name="email" 
                                            value="<?= esc($user['email']) ?>"
                                            class="form-input w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-purple-start focus:border-purple-start bg-gray-100 cursor-not-allowed"
                                            readonly>
                                        <?php if (isset($validation) && $validation->hasError('email')): ?>
                                            <p class="mt-1 text-sm text-red-600"><?= $validation->getError('email') ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="mt-6 flex justify-end">
                                    <button type="submit" class="bg-gradient-main text-white px-6 py-2 rounded-md font-medium hover:opacity-90 transition-opacity">
                                        Update Profile
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Security Tab Content -->
                        <div id="content-security" class="tab-content hidden p-6">
                            <form method="POST" action="<?= base_url('profile/change-password') ?>">
                                <?= csrf_field() ?>
                                
                                <div class="space-y-6">
                                    <!-- Current Password -->
                                    <div>
                                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                                        <input type="password" id="current_password" name="current_password" 
                                               class="form-input w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-purple-start focus:border-purple-start"
                                               required>
                                        <?php if (isset($validation) && $validation->hasError('current_password')): ?>
                                            <p class="mt-1 text-sm text-red-600"><?= $validation->getError('current_password') ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- New Password -->
                                    <div>
                                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                                        <input type="password" id="new_password" name="new_password" 
                                               class="form-input w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-purple-start focus:border-purple-start"
                                               required>
                                        <?php if (isset($validation) && $validation->hasError('new_password')): ?>
                                            <p class="mt-1 text-sm text-red-600"><?= $validation->getError('new_password') ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div>
                                        <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                                        <input type="password" id="confirm_password" name="confirm_password" 
                                               class="form-input w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-purple-start focus:border-purple-start"
                                               required>
                                        <?php if (isset($validation) && $validation->hasError('confirm_password')): ?>
                                            <p class="mt-1 text-sm text-red-600"><?= $validation->getError('confirm_password') ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Password Requirements -->
                                    <div class="bg-gray-50 p-4 rounded-md">
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">Persyaratan Password:</h4>
                                        <ul class="text-sm text-gray-600 space-y-1">
                                            <li>• Minimal 8 karakter</li>
                                            <li>• Kombinasi huruf besar dan kecil</li>
                                            <li>• Mengandung angka</li>
                                            <li>• Mengandung karakter khusus (!@#$%^&*)</li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="mt-6 flex justify-end">
                                    <button type="submit" class="bg-gradient-main text-white px-6 py-2 rounded-md font-medium hover:opacity-90 transition-opacity">
                                        Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Remove active class from all tabs
                    tabButtons.forEach(btn => {
                        btn.classList.remove('active', 'border-purple-start', 'text-purple-start');
                        btn.classList.add('border-transparent', 'text-gray-500');
                    });

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Add active class to clicked tab
                    button.classList.add('active', 'border-purple-start', 'text-purple-start');
                    button.classList.remove('border-transparent', 'text-gray-500');

                    // Show corresponding content
                    const tabId = button.id.replace('tab-', 'content-');
                    document.getElementById(tabId).classList.remove('hidden');
                });
            });

            // Password confirmation validation
            const newPassword = document.getElementById('new_password');
            const confirmPassword = document.getElementById('confirm_password');

            function validatePassword() {
                if (newPassword.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('Password tidak cocok');
                } else {
                    confirmPassword.setCustomValidity('');
                }
            }

            newPassword?.addEventListener('input', validatePassword);
            confirmPassword?.addEventListener('input', validatePassword);
        });
    </script>
</body>
</html>