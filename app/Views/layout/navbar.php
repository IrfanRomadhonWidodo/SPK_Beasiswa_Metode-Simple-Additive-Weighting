<!-- Top Navigation -->
<nav class="bg-white shadow-sm border-b border-gray-200 px-4 py-3">
    <div class="flex items-center justify-between">
        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
            <span class="block w-6 h-0.5 bg-gray-600 mb-1"></span>
            <span class="block w-6 h-0.5 bg-gray-600 mb-1"></span>
            <span class="block w-6 h-0.5 bg-gray-600"></span>
        </button>

        <!-- User Info -->
        <div class="flex items-center ml-auto">
            <div class="dropdown relative">
                <div class="flex items-center space-x-2 cursor-pointer hover:bg-gray-50 rounded-lg p-1.5 transition-colors">
                    <div class="text-right hidden sm:block">
                        <div class="text-sm font-medium text-gray-800"><?= esc($user['full_name']) ?></div>
                        <div class="text-xs text-gray-500"><?= esc($user['email']) ?></div>
                    </div>
                    <div class="w-9 h-9 bg-gradient-to-br from-gray-800 to-gray-600 rounded-full flex items-center justify-center shadow-sm">
                        <!-- User Avatar Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <!-- Chevron Down Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-400 transition-transform dropdown-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                
                <!-- Dropdown Menu -->
                <div class="dropdown-content absolute right-0 top-full mt-1 w-44 bg-white rounded-md shadow-lg border border-gray-200 py-1 z-50 hidden">
                    <!-- User Info in Dropdown (mobile) -->
                    <div class="px-3 py-2 border-b border-gray-100 sm:hidden">
                        <div class="text-sm font-medium text-gray-800"><?= esc($user['full_name']) ?></div>
                        <div class="text-xs text-gray-500"><?= esc($user['email']) ?></div>
                    </div>
                    
                    <a href="#profile" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                        <!-- Profile Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <span class="whitespace-nowrap">Profile</span>
                    </a>
                    
                    <div class="border-t border-gray-100 my-1"></div>
                    
                    <form action="<?= base_url('auth/logout') ?>" method="POST" class="block">
                        <?= csrf_field() ?>
                        <button type="submit" class="flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors w-full text-left">
                            <!-- Logout Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
.dropdown-content {
    animation: fadeInDown 0.2s ease-out;
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Remove hover behavior - only use JavaScript */
.dropdown .dropdown-content {
    display: none;
}

.dropdown.active .dropdown-content {
    display: block;
}

.dropdown.active .dropdown-chevron {
    transform: rotate(180deg);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.querySelector('.dropdown');
    const dropdownContent = document.querySelector('.dropdown-content');
    const chevron = document.querySelector('.dropdown-chevron');
    
    if (dropdown && dropdownContent) {
        // Toggle dropdown on click
        dropdown.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdown.classList.toggle('active');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });
        
        // Close dropdown when pressing Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                dropdown.classList.remove('active');
            }
        });
    }
});
</script>