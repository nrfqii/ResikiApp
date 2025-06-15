@extends('layouts.main')

@section('title', 'Dashboard Konsumen')
@section('subtitle', 'Ikhtisar aktivitas Anda dan layanan kebersihan')

@section('content')
    <div class="space-y-4 sm:space-y-6 lg:space-y-8"> <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 md:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between smooth-transition">
            <div class="mb-4 sm:mb-0 sm:mr-4">
                <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-2">Halo, {{ auth()->user()->name ?? 'Pengguna' }}!</h2>
                <p class="text-sm sm:text-base text-gray-600 leading-relaxed max-w-md"> Selamat datang kembali di ResikiApp. Di sini Anda bisa mengelola pesanan kebersihan Anda dengan mudah.
                </p>
            </div>
            <a href="{{ route('pesan.index') }}" class="w-full sm:w-auto bg-primary text-white px-4 py-2 sm:px-5 sm:py-2.5 rounded-full text-sm sm:text-base font-semibold hover:bg-primary-dark transform hover:scale-105 transition duration-200 shadow-md hover:shadow-xl flex items-center justify-center">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                </svg>
                Pesan Jasa Baru
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-5 border border-transparent hover:border-primary transform hover:scale-105 transition duration-300 smooth-transition flex items-center space-x-3">
                <div class="p-2 bg-yellow-100 rounded-full text-yellow-600 flex-shrink-0">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium">Pesanan Menunggu</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $pendingOrdersCount }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-5 border border-transparent hover:border-primary transform hover:scale-105 transition duration-300 smooth-transition flex items-center space-x-3">
                <div class="p-2 bg-green-100 rounded-full text-green-600 flex-shrink-0">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium">Pesanan Selesai</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $completedOrdersCount }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-5 border border-transparent hover:border-primary transform hover:scale-105 transition duration-300 smooth-transition flex items-center space-x-3">
                <div class="p-2 bg-blue-100 rounded-full text-blue-600 flex-shrink-0">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium">Ulasan Diberikan</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $reviewsCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6">
            <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zm-3 8a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm1 3a1 1 0 100 2h4a1 1 0 100-2H8z" clip-rule="evenodd"></path>
                </svg>
                Pesanan Terbaru Anda
            </h3>
            @if ($recentOrders->isEmpty())
                <p class="text-gray-600 text-center py-4">Anda belum memiliki pesanan terbaru.</p>
            @else
                <div class="block md:hidden space-y-4">
                    @foreach ($recentOrders as $order)
                        <div class="border border-gray-200 rounded-xl p-4">
                            <div class="flex justify-between items-center mb-2">
                                <p class="text-sm font-medium text-gray-900">#{{ $order->id }}</p>
                                @php
                                    $statusClass = '';
                                    switch ($order->status) {
                                        case 'pending':
                                            $statusClass = 'bg-yellow-100 text-yellow-800';
                                            break;
                                        case 'dikonfirmasi':
                                            $statusClass = 'bg-blue-100 text-blue-800';
                                            break;
                                        case 'diproses':
                                            $statusClass = 'bg-purple-100 text-purple-800';
                                            break;
                                        case 'selesai':
                                            $statusClass = 'bg-green-100 text-green-800';
                                            break;
                                        case 'dibatalkan':
                                            $statusClass = 'bg-red-100 text-red-800';
                                            break;
                                        default:
                                            $statusClass = 'bg-gray-100 text-gray-800';
                                            break;
                                    }
                                @endphp
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                            </div>
                            <p class="text-sm text-gray-600">{{ $order->nama_paket ?? $order->custom_request }}</p>
                            <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($order->tanggal)->format('d F Y') }}</p>
                            <a href="{{ route('pesan.show', $order->id) }}" class="text-primary hover:text-primary-dark text-sm font-medium mt-2 inline-block">Detail</a>
                        </div>
                    @endforeach
                </div>
                <div class="hidden md:block overflow-x-auto custom-scrollbar -mx-4 sm:-mx-6 px-4 sm:px-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID Pesanan
                                </th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Layanan
                                </th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($recentOrders as $order)
                                <tr>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        #{{ $order->id }}
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $order->nama_paket ?? $order->custom_request }}
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($order->tanggal)->format('d F Y') }}
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        @php
                                            $statusClass = '';
                                            switch ($order->status) {
                                                case 'pending':
                                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                                    break;
                                                case 'dikonfirmasi':
                                                    $statusClass = 'bg-blue-100 text-blue-800';
                                                    break;
                                                case 'diproses':
                                                    $statusClass = 'bg-purple-100 text-purple-800';
                                                    break;
                                                case 'selesai':
                                                    $statusClass = 'bg-green-100 text-green-800';
                                                    break;
                                                case 'dibatalkan':
                                                    $statusClass = 'bg-red-100 text-red-800';
                                                    break;
                                                default:
                                                    $statusClass = 'bg-gray-100 text-gray-800';
                                                    break;
                                            }
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('pesan.show', $order->id) }}" class="text-primary hover:text-primary-dark">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <div class="mt-4 text-center sm:text-right">
                <a href="{{ route('pesan.riwayat') }}" class="text-primary hover:text-primary-dark font-medium flex items-center justify-center sm:justify-end">
                    Lihat Semua Riwayat Pesanan
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
            <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 flex flex-col items-start smooth-transition">
                <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    Berikan Ulasan Anda
                </h3>
                <p class="text-sm sm:text-base text-gray-600 mb-3">
                    Bagikan pengalaman Anda menggunakan layanan kami. Ulasan Anda sangat berarti!
                </p>
                <a href="{{ route('ulasan.index') }}" class="w-full sm:w-auto bg-gray-100 text-gray-800 px-4 py-2 rounded-full font-semibold hover:bg-gray-200 transition duration-200 text-sm flex items-center justify-center">
                    Tulis Ulasan
                </a>
            </div>

            <div class="bg-primary text-white rounded-2xl shadow-lg p-4 sm:p-6 flex flex-col items-start justify-center smooth-transition">
                <h3 class="text-lg sm:text-xl font-bold mb-3 flex items-center">
                    <svg class="w-5 h-5 text-white mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                    </svg>
                    Butuh Bantuan?
                </h3>
                <p class="text-sm sm:text-base text-white/90 mb-3">
                    Jangan ragu menghubungi kami jika Anda memiliki pertanyaan atau kendala.
                </p>
                <a href="/kontak" class="w-full sm:w-auto bg-white text-primary px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition duration-200 text-sm flex items-center justify-center">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
@endsection