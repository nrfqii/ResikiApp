<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ResikiApp')</title>

    <link rel="icon" type="image/png" href="{{ asset('logo-no-bg.png') }}">
    <!-- Di layouts/main.blade.php atau sebelum </head> -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places&callback=initAutocomplete" async
        defer></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0ABAB5',
                        'primary-dark': '#088D88',
                    }
                }
            },
            plugins: [],
        }
    </script>

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

        /* Enhanced gradient background */
        .gradient-bg {
            background: linear-gradient(135deg, #0ABAB5 0%, #089e9a 50%, #0d7377 100%);
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
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s;
        }

        .nav-item:hover::before {
            left: 100%;
        }

        /* Icon-only mode styles */
        .sidebar-collapsed .nav-text {
            opacity: 0;
            width: 0;
            margin: 0;
            overflow: hidden;
        }

        .sidebar-collapsed .nav-item {
            justify-content: center;
            align-items: center;
            display: flex;
            text-align: center;
        }

        /* Tooltip styles */
        .tooltip {
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            white-space: nowrap;
            margin-left: 0.5rem;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s;
            z-index: 1000;
        }

        .tooltip::before {
            content: '';
            position: absolute;
            left: -4px;
            top: 50%;
            transform: translateY(-50%);
            border: 4px solid transparent;
            border-right-color: rgba(0, 0, 0, 0.8);
        }

        .sidebar-collapsed .nav-item:hover .tooltip {
            opacity: 1;
            visibility: visible;
        }

        /* Enhanced card styles */
        .card-hover:hover {
            border-color: #0ABAB5;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .selected-package {
            border-color: #0ABAB5;
            background-color: rgba(10, 186, 181, 0.05);
        }

        /* Glassmorphism effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Pulse animation for notifications */
        .pulse-animation {
            animation: pulse-glow 2s infinite;
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 5px rgba(239, 68, 68, 0.5);
            }

            50% {
                box-shadow: 0 0 20px rgba(239, 68, 68, 0.8);
            }
        }

        /* Hover glow effect for user avatar */
        .user-avatar:hover {
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="flex min-h-screen" x-data="{
        sidebarOpen: false,
        sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' || false,
        isMobile: window.innerWidth < 768,
        init() {
            this.$watch('sidebarCollapsed', value => {
                localStorage.setItem('sidebarCollapsed', value);
            });
    
            // Listen for window resize to update isMobile
            window.addEventListener('resize', () => {
                this.isMobile = window.innerWidth < 768;
                if (this.isMobile) {
                    this.sidebarOpen = false; // Close sidebar on mobile
                }
            });
    
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', (e) => {
                if (this.isMobile && this.sidebarOpen && !e.target.closest('.sidebar-container') && !e.target.closest('.mobile-toggle')) {
                    this.sidebarOpen = false;
                }
            });
        }
    }">
        <!-- Mobile overlay -->
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
            class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-custom z-40 md:hidden">
        </div>

        <!-- Sidebar -->
        <div class="sidebar-container fixed inset-y-0 left-0 z-50 gradient-bg text-white flex flex-col shadow-2xl smooth-transition"
            :class="{
                'w-72': (!sidebarCollapsed && !isMobile) || (isMobile && sidebarOpen),
                'w-20': sidebarCollapsed && !isMobile && !sidebarOpen,
                'translate-x-0': (sidebarOpen && isMobile) || (!isMobile),
                '-translate-x-full': !sidebarOpen && isMobile,
                'sidebar-collapsed': sidebarCollapsed && !isMobile
            }"
            x-show="sidebarOpen || !isMobile" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full">

            <!-- Header -->
            <div class="relative p-6 border-b border-white/20 min-h-[100px]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl overflow-hidden shadow-lg ring-2 ring-white/20">
                            <img src="{{ asset('logo.jpg') }}" alt="Logo ResikiApp"
                                class="w-full h-full object-cover" />
                        </div>
                        <div class="nav-text smooth-transition">
                            <h1 class="text-xl font-bold tracking-wide">ResikiApp</h1>
                            <p class="text-xs text-white/70">Cleaning Service</p>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false"
                        class="md:hidden p-2 hover:bg-white/10 rounded-lg smooth-transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- User Profile -->
            <div class="p-6 border-b border-white/20">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-12 h-12 glass-effect rounded-xl flex items-center justify-center user-avatar smooth-transition">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 nav-text smooth-transition">
                        <p class="font-semibold text-sm">{{ auth()->user()->name ?? 'Guest' }}</p>
                        <p class="text-xs text-white/70 capitalize">{{ auth()->user()->role ?? 'user' }}</p>
                    </div>
                    <div class="w-3 h-3 bg-green-400 rounded-full pulse-animation"></div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-2 custom-scrollbar overflow-y-auto">
                @php
                    $role = auth()->user()->role ?? '';
                @endphp

                @if ($role === 'konsumen')
                    <div class="space-y-2">
                        <div
                            class="px-3 py-2 text-xs font-semibold text-white/60 uppercase tracking-wider nav-text smooth-transition">
                            Menu Utama
                        </div>
                        <a href="/dashboard/konsumen"
                            class="nav-item flex items-center px-4 py-3 rounded-xl smooth-transition relative {{ request()->is('dashboard/konsumen') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}"
                            :class="{ 'justify-center': sidebarCollapsed && !isMobile }">
                            <svg class="w-5 h-5 flex-shrink-0 smooth-transition"
                                :class="{ 'mr-0': sidebarCollapsed && !isMobile, 'mr-3': !(sidebarCollapsed && !isMobile) }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            <span class="font-medium nav-text smooth-transition">Dashboard</span>
                            <div class="tooltip">Dashboard</div>
                        </a>
                        <a href="/pesan"
                            class="nav-item flex items-center px-4 py-3 rounded-xl smooth-transition relative {{ request()->is('pesan*') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}"
                            :class="{ 'justify-center': sidebarCollapsed && !isMobile }">
                            <svg class="w-5 h-5 flex-shrink-0 smooth-transition"
                                :class="{ 'mr-0': sidebarCollapsed && !isMobile, 'mr-3': !(sidebarCollapsed && !isMobile) }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4">
                                </path>
                            </svg>
                            <span class="font-medium nav-text smooth-transition">Pesan Jasa</span>
                            @if (isset($notificationCount) && $notificationCount > 0)
                                <div class="ml-auto nav-text smooth-transition">
                                    <span
                                        class="bg-red-500 text-white text-xs px-2 py-1 rounded-full pulse-animation">{{ $notificationCount }}</span>
                                </div>
                            @endif
                            <div class="tooltip">Pesan Jasa</div>
                        </a>
                        <a href="/ulasan"
                            class="nav-item flex items-center px-4 py-3 rounded-xl smooth-transition relative {{ request()->is('ulasan*') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}"
                            :class="{ 'justify-center': sidebarCollapsed && !isMobile }">
                            <svg class="w-5 h-5 flex-shrink-0 smooth-transition"
                                :class="{ 'mr-0': sidebarCollapsed && !isMobile, 'mr-3': !(sidebarCollapsed && !isMobile) }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                </path>
                            </svg>
                            <span class="font-medium nav-text smooth-transition">Ulasan</span>
                            <div class="tooltip">Ulasan</div>
                        </a>
                    </div>
                @elseif($role === 'petugas')
                    <div class="space-y-2">
                        <div
                            class="px-3 py-2 text-xs font-semibold text-white/60 uppercase tracking-wider nav-text smooth-transition">
                            Menu Petugas
                        </div>
                        <a href="/dashboard/petugas"
                            class="nav-item flex items-center px-4 py-3 rounded-xl smooth-transition relative {{ request()->is('dashboard/petugas') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5 mr-3 flex-shrink-0 smooth-transition"
                                :class="{ 'mr-0': sidebarCollapsed && !isMobile, 'mr-3': !(sidebarCollapsed && !isMobile) }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            <span class="font-medium nav-text smooth-transition">Dashboard</span>
                            <div class="tooltip">Dashboard</div>
                        </a>
                        <a href="/petugas/pesanan"
                            class="nav-item flex items-center px-4 py-3 rounded-xl smooth-transition relative {{ request()->is('petugas/pesanan*') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5 mr-3 flex-shrink-0 smooth-transition"
                                :class="{ 'mr-0': sidebarCollapsed && !isMobile, 'mr-3': !(sidebarCollapsed && !isMobile) }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                </path>
                            </svg>
                            <span class="font-medium nav-text smooth-transition">Pesanan Masuk</span>
                            @if (isset($pendingOrdersCount) && $pendingOrdersCount > 0)
                                <div class="ml-auto nav-text smooth-transition">
                                    <span
                                        class="bg-yellow-500 text-white text-xs px-2 py-1 rounded-full pulse-animation">{{ $pendingOrdersCount }}</span>
                                </div>
                            @endif
                            <div class="tooltip">Pesanan Masuk</div>
                        </a>
                        <a href="/petugas/riwayat"
                            class="nav-item flex items-center px-4 py-3 rounded-xl smooth-transition relative {{ request()->is('petugas/riwayat*') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}">
                            <svg class="w-5 h-5 mr-3 flex-shrink-0 smooth-transition"
                                :class="{ 'mr-0': sidebarCollapsed && !isMobile, 'mr-3': !(sidebarCollapsed && !isMobile) }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium nav-text smooth-transition">Riwayat</span>
                            <div class="tooltip">Riwayat</div>
                        </a>
                    </div>
                @endif
            </nav>

            <!-- Logout Button -->
            <div class="p-4 border-t border-white/20">
                <form action="/logout" method="POST" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full nav-item flex items-center px-4 py-3 rounded-xl hover:bg-red-500/20 text-red-100 smooth-transition group relative"
                        :class="{ 'justify-center': sidebarCollapsed && !isMobile }">
                        <svg class="w-5 h-5 mr-3 group-hover:rotate-12 smooth-transition flex-shrink-0"
                            :class="{ 'mr-0': sidebarCollapsed && !isMobile, 'mr-3': !(sidebarCollapsed && !isMobile) }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        <span class="font-medium nav-text smooth-transition">Logout</span>
                        <div class="tooltip">Logout</div>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col smooth-transition"
            :class="{
                'md:ml-72': !sidebarCollapsed && !isMobile,
                'md:ml-20': sidebarCollapsed && !isMobile,
                'ml-0': isMobile
            }">

            <!-- Header -->
            <header class="bg-white/80 backdrop-blur-sm shadow-sm border-b border-gray-200/50 sticky top-0 z-30">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <div class="flex items-center space-x-4">
                            <!-- Mobile hamburger -->
                            <button @click="sidebarOpen = !sidebarOpen"
                                class="mobile-toggle md:hidden p-2 rounded-lg text-[#0ABAB5] hover:bg-[#0ABAB5]/10 smooth-transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        :d="sidebarOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'"></path>
                                </svg>
                            </button>

                            <!-- Desktop sidebar toggle -->
                            <button @click="sidebarCollapsed = !sidebarCollapsed"
                                class="hidden md:flex p-2 rounded-lg text-[#0ABAB5] hover:bg-[#0ABAB5]/10 smooth-transition"
                                x-show="!isMobile">
                                <svg class="w-6 h-6 smooth-transition" :class="{ 'rotate-180': sidebarCollapsed }"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                                </svg>
                            </button>

                            <div>
                                <h1 class="text-xl font-bold text-[#0ABAB5]">@yield('title', 'Dashboard')</h1>
                                <p class="text-sm text-gray-500 hidden sm:block">@yield('subtitle', 'Manage your cleaning services')</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <button class="relative p-2 text-gray-400 hover:text-[#0ABAB5] smooth-transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-5 5v-5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 7V6a3 3 0 116 0v1M9 7h6l1 10H8L9 7z"></path>
                                </svg>
                                @if (isset($totalNotifications) && $totalNotifications > 0)
                                    <span
                                        class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center pulse-animation">{{ $totalNotifications }}</span>
                                @endif
                            </button>

                            <div class="hidden sm:flex items-center space-x-2 text-sm">
                                <span class="text-gray-600">Halo,</span>
                                <span
                                    class="font-semibold text-[#0ABAB5]">{{ auth()->user()->name ?? 'Guest' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 p-4 sm:p-6 lg:px-8 lg:py-6">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
