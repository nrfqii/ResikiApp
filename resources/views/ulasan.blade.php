<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ulasan - ResikiApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Smooth transitions */
        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Backdrop blur for mobile overlay */
        .backdrop-blur-custom {
            backdrop-filter: blur(8px);
        }

        /* Gradient background */
        .gradient-bg {
            background: linear-gradient(135deg, #0ABAB5 0%, #089e9a 100%);
        }

        /* Hover effects */
        .nav-item {
            position: relative;
            overflow: hidden;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s;
        }

        .nav-item:hover::before {
            left: 100%;
        }

        /* Review card animations */
        .review-card {
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        .review-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        /* Star rating animations */
        .star {
            transition: all 0.2s ease;
        }

        .star:hover {
            transform: scale(1.2);
        }

        /* Floating animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Custom button styles */
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(240, 147, 251, 0.3);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
<div class="flex min-h-screen" x-data="{ sidebarOpen: false, showModal: false, selectedReview: null }">
    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-custom z-40 md:hidden">
    </div>

    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 w-72 gradient-bg text-white flex flex-col shadow-2xl smooth-transition"
         :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
        <!-- Header -->
        <div class="relative p-6 border-b border-white/20">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-wide">ResikiApp</h1>
                        <p class="text-xs text-white/70">Cleaning Service</p>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="md:hidden p-2 hover:bg-white/10 rounded-lg smooth-transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- User Profile -->
        <div class="p-6 border-b border-white/20">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-sm">John Doe</p>
                    <p class="text-xs text-white/70 capitalize">konsumen</p>
                </div>
                <div class="w-3 h-3 bg-green-400 rounded-full"></div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-4 space-y-2 custom-scrollbar overflow-y-auto">
            <div class="space-y-2">
                <div class="px-3 py-2 text-xs font-semibold text-white/60 uppercase tracking-wider">
                    Menu Utama
                </div>
                <a href="/dashboard/konsumen" class="nav-item flex items-center px-4 py-3 rounded-xl smooth-transition hover:bg-white/10">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="/pesan" class="nav-item flex items-center px-4 py-3 rounded-xl smooth-transition hover:bg-white/10">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                    </svg>
                    <span class="font-medium">Pesan Jasa</span>
                </a>
                <a href="/ulasan" class="nav-item flex items-center px-4 py-3 rounded-xl smooth-transition bg-white/20 shadow-lg">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    <span class="font-medium">Ulasan</span>
                </a>
            </div>
        </nav>

        <!-- Logout Button -->
        <div class="p-4 border-t border-white/20">
            <button class="w-full flex items-center px-4 py-3 rounded-xl hover:bg-red-500/20 text-red-100 smooth-transition group">
                <svg class="w-5 h-5 mr-3 group-hover:rotate-12 smooth-transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span class="font-medium">Logout</span>
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col md:ml-72">
        <!-- Top Bar -->
        <header class="bg-white/80 backdrop-blur-sm shadow-sm border-b border-gray-200/50 sticky top-0 z-30">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-4">
                        <button @click="sidebarOpen = !sidebarOpen" 
                                class="md:hidden p-2 rounded-lg text-[#0ABAB5] hover:bg-[#0ABAB5]/10 smooth-transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <div>
                            <h1 class="text-xl font-bold gradient-text">Ulasan & Rating</h1>
                            <p class="text-sm text-gray-500 hidden sm:block">Lihat dan kelola ulasan layanan Anda</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-400 hover:text-[#667eea] smooth-transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7V6a3 3 0 116 0v1M9 7h6l1 10H8L9 7z"></path>
                            </svg>
                        </button>
                        
                        <!-- User Info -->
                        <div class="hidden sm:flex items-center space-x-2 text-sm">
                            <span class="text-gray-600">Halo,</span>
                            <span class="font-semibold gradient-text">John Doe</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 p-4 sm:p-6 lg:px-8 lg:py-6">
            <div class="max-w-7xl mx-auto">
                
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-6 rounded-2xl text-white float-animation">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm">Total Ulasan</p>
                                <p class="text-2xl font-bold">124</p>
                            </div>
                            <div class="bg-white/20 p-3 rounded-xl">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-pink-500 to-rose-600 p-6 rounded-2xl text-white" style="animation-delay: 0.1s">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-pink-100 text-sm">Rating Rata-rata</p>
                                <p class="text-2xl font-bold">4.8</p>
                            </div>
                            <div class="bg-white/20 p-3 rounded-xl">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-indigo-500 to-blue-600 p-6 rounded-2xl text-white float-animation" style="animation-delay: 0.2s">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-indigo-100 text-sm">Bulan Ini</p>
                                <p class="text-2xl font-bold">32</p>
                            </div>
                            <div class="bg-white/20 p-3 rounded-xl">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-emerald-500 to-teal-600 p-6 rounded-2xl text-white float-animation" style="animation-delay: 0.3s">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-emerald-100 text-sm">Rating 5 ⭐</p>
                                <p class="text-2xl font-bold">89%</p>
                            </div>
                            <div class="bg-white/20 p-3 rounded-xl">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                        <h2 class="text-xl font-bold gradient-text">Filter Ulasan</h2>
                        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                            <select class="px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option>Semua Rating</option>
                                <option>5 Bintang</option>
                                <option>4 Bintang</option>
                                <option>3 Bintang</option>
                                <option>2 Bintang</option>
                                <option>1 Bintang</option>
                            </select>
                            <select class="px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option>Semua Waktu</option>
                                <option>Bulan Ini</option>
                                <option>3 Bulan Terakhir</option>
                                <option>6 Bulan Terakhir</option>
                                <option>Tahun Ini</option>
                            </select>
                            <button class="btn-primary px-6 py-2 text-white rounded-xl font-medium">
                                Filter
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Reviews Grid -->
                <div class="space-y-6">
                    <!-- Review Item 1 -->
                    <div class="review-card bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                                        S
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Sari Dewi</h3>
                                        <p class="text-sm text-gray-500">Pembersihan Rumah Premium</p>
                                        <p class="text-xs text-gray-400">15 Juni 2024</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <span class="text-2xl font-bold text-yellow-500">5.0</span>
                                    <div class="flex space-x-1">
                                        <svg class="star w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg class="star w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg class="star w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg class="star w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg class="star w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <p class="text-gray-700 leading-relaxed">
                                    Pelayanan sangat memuaskan! Tim cleaning sangat profesional dan detail dalam membersihkan rumah. Hasil pembersihan melebihi ekspektasi saya. Akan menggunakan jasa ini lagi di masa depan.
                                </p>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Selesai
                                    </span>
                                    <span class="text-sm text-gray-500">Petugas: Ahmad Roni</span>
                                </div>
                                <button @click="selectedReview = 1; showModal = true" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Review Item 2 -->
                    <div class="review-card bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold">
                                        B
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Budi Santoso</h3>
                                        <p class="text-sm text-gray-500">Pembersihan Kantor</p>
                                        <p class="text-xs text-gray-400">12 Juni 2024</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <span class="text-2xl font-bold text-yellow-500">4.5</span>
                                    <div class="flex space-x-1">
                                        <svg class="star w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg class="star w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg class="star w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg class="star w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg class="star w-5 h-5 text-gray-300 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <p class="text-gray-700 leading-relaxed">
                                    Secara keseluruhan bagus, namun ada beberapa area yang kurang maksimal. Petugas datang tepat waktu dan bekerja dengan cepat. Mungkin perlu lebih teliti lagi untuk sudut-sudut ruangan.
                                </p>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Selesai
                                    </span>
                                    <span class="text-sm text-gray-500">Petugas: Siti Rahmawati</span>
                                </div>
                                <button @click="selectedReview = 2; showModal = true" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Review Item 3 -->
                    <div class="review-card bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-full flex items-center justify-center text-white font-bold">
                                        L
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Lisa Wulandari</h3>
                                        <p class="text-sm text-gray-500">Pembersihan Karpet & Sofa</p>
                                        <p class="text-xs text-gray-400">10 Juni 2024</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <span class="text-2xl font-bold text-yellow-500">5.0</span>
                                    <div class="flex space-x-1">
                                        <svg class="star w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg class="star w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg class="star w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg class="star w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg class="star w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <p class="text-gray-700 leading-relaxed">
                                    Luar biasa! Karpet dan sofa yang sudah lama kotor akhirnya bersih seperti baru. Tim cleaning menggunakan peralatan yang canggih dan ramah lingkungan. Sangat recommended!
                                </p>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Selesai
                                    </span>
                                    <span class="text-sm text-gray-500">Petugas: Dedi Kurniawan</span>
                                </div>
                                <button @click="selectedReview = 3; showModal = true" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Review Item 4 -->
                    <div class="review-card bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-full flex items-center justify-center text-white font-bold">
                                        R
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Rudi Hermawan</h3>
                                        <p class="text-sm text-gray-500">Pembersihan Rumah Standar</p>
                                        <p class="text-xs text-gray-400">8 Juni 2024</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <span class="text-2xl font-bold text-yellow-500">3.5</span>
                                    <div class="flex space-x-1">
                                        <svg class="star w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg class="star w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg class="star w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg class="star w-5 h-5 text-gray-300 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg class="star w-5 h-5 text-gray-300 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <p class="text-gray-700 leading-relaxed">
                                    Pelayanan cukup baik, namun ada keterlambatan sekitar 30 menit dari jadwal yang ditentukan. Hasil pembersihan standar, tidak ada yang istimewa. Harga sesuai dengan kualitas yang diberikan.
                                </p>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Selesai
                                    </span>
                                    <span class="text-sm text-gray-500">Petugas: Maya Sari</span>
                                </div>
                                <button @click="selectedReview = 4; showModal = true" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="flex items-center justify-between mt-8">
                    <div class="text-sm text-gray-500">
                        Menampilkan 1-4 dari 124 ulasan
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-2 text-sm text-gray-400 bg-white rounded-lg border border-gray-300 hover:bg-gray-50">
                            Previous
                        </button>
                        <button class="px-3 py-2 text-sm text-white bg-purple-600 rounded-lg">
                            1
                        </button>
                        <button class="px-3 py-2 text-sm text-gray-700 bg-white rounded-lg border border-gray-300 hover:bg-gray-50">
                            2
                        </button>
                        <button class="px-3 py-2 text-sm text-gray-700 bg-white rounded-lg border border-gray-300 hover:bg-gray-50">
                            3
                        </button>
                        <button class="px-3 py-2 text-sm text-gray-700 bg-white rounded-lg border border-gray-300 hover:bg-gray-50">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Detail Ulasan -->
    <div x-show="showModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showModal = false"></div>
            
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="w-full">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Detail Ulasan</h3>
                                <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-center space-x-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-xl">
                                        S
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Sari Dewi</h4>
                                        <p class="text-sm text-gray-500">Pembersihan Rumah Premium</p>
                                        <p class="text-xs text-gray-400">15 Juni 2024 - 14:30</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <span class="text-3xl font-bold text-yellow-500">5.0</span>
                                    <div class="flex space-x-1">
                                        <svg class="w-6 h-6 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg class="w-6 h-6 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg class="w-6 h-6 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg class="w-6 h-6 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg class="w-6 h-6 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 p-4 rounded-xl">
                                    <p class="text-gray-700 leading-relaxed">
                                        Pelayanan sangat memuaskan! Tim cleaning sangat profesional dan detail dalam membersihkan rumah. Hasil pembersihan melebihi ekspektasi saya. Semua peralatan yang digunakan berkualitas tinggi dan ramah lingkungan. Petugas datang tepat waktu dan bekerja dengan sangat teliti. Akan menggunakan jasa ini lagi di masa depan dan merekomendasikan kepada teman-teman.
                                    </p>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-gray-500">Petugas:</span>
                                        <span class="font-medium">Ahmad Roni</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Durasi:</span>
                                        <span class="font-medium">3 jam</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Biaya:</span>
                                        <span class="font-medium">Rp 250.000</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Status:</span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Selesai
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button @click="showModal = false" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 btn-primary text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>