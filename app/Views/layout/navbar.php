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
