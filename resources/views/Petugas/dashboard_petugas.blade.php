@extends('layouts.main')

@section('title', 'Dashboard Petugas')
@section('subtitle', 'Ikhtisar pesanan masuk dan tugas Anda')

@section('content')
    <div class="space-y-6 lg:space-y-8"> {{-- Konsisten dengan spacing responsif --}}

        <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 md:p-10 flex flex-col sm:flex-row items-start sm:items-center justify-between smooth-transition">
            <div class="mb-4 sm:mb-0 sm:mr-6">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-800 mb-2">Halo, Petugas {{ auth()->user()->name ?? '' }}!</h2>
                <p class="text-base sm:text-lg text-gray-600 leading-relaxed max-w-xl">
                    Di sini Anda dapat melihat pesanan masuk, mengelola jadwal, dan memperbarui status pekerjaan.
                </p>
            </div>
            <a href="/petugas/pesanan" class="w-full sm:w-auto bg-primary text-white px-5 py-2.5 sm:px-6 sm:py-3 rounded-full text-base sm:text-lg font-semibold hover:bg-primary-dark transform hover:scale-105 transition duration-200 shadow-md hover:shadow-xl flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                Lihat Pesanan Masuk
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <div class="bg-white rounded-2xl shadow-lg p-5 sm:p-6 border border-transparent hover:border-primary transform hover:scale-105 transition duration-300 smooth-transition flex items-center space-x-4">
                <div class="p-3 bg-red-100 rounded-full text-red-600 flex-shrink-0">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7V6a3 3 0 116 0v1M9 7h6l1 10H8L9 7z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm sm:text-base text-gray-500 font-medium">Pesanan Baru</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $newOrdersCount ?? 0 }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-5 sm:p-6 border border-transparent hover:border-primary transform hover:scale-105 transition duration-300 smooth-transition flex items-center space-x-4">
                <div class="p-3 bg-blue-100 rounded-full text-blue-600 flex-shrink-0">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm sm:text-base text-gray-500 font-medium">Sedang Diproses</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $inProgressOrdersCount ?? 0 }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-5 sm:p-6 border border-transparent hover:border-primary transform hover:scale-105 transition duration-300 smooth-transition flex items-center space-x-4">
                <div class="p-3 bg-green-100 rounded-full text-green-600 flex-shrink-0">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm sm:text-base text-gray-500 font-medium">Selesai Hari Ini</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $completedTodayOrdersCount ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">
            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zm-3 8a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm1 3a1 1 0 100 2h4a1 1 0 100-2H8z" clip-rule="evenodd"></path>
                </svg>
                Pesanan Masuk Terbaru
            </h3>
            <div class="overflow-x-auto custom-scrollbar -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID Pesanan
                            </th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Konsumen
                            </th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Layanan
                            </th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                Tanggal & Waktu
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
                        @forelse ($latestIncomingOrders as $order)
                            <tr>
                                <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $order->id }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $order->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $order->nama_paket ?? $order->paket->nama_paket ?? 'N/A' }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600 hidden md:table-cell">
                                    {{ \Carbon\Carbon::parse($order->tanggal)->format('d F Y') }}, {{ \Carbon\Carbon::parse($order->waktu)->format('H:i') }} WIB
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap">
                                    @php
                                        $statusClass = '';
                                        switch ($order->status) {
                                            case 'pending':
                                                $statusClass = 'bg-yellow-100 text-yellow-800';
                                                break;
                                            case 'dikonfirmasi':
                                                $statusClass = 'bg-purple-100 text-purple-800';
                                                break;
                                            case 'diproses':
                                                $statusClass = 'bg-blue-100 text-blue-800';
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
                                    <a href="{{ route('order.detail', $order->id) }}" class="text-primary hover:text-primary-dark mr-3">Detail</a>
                                    @if ($order->status == 'pending')
                                        <button onclick="updateOrderStatus({{ $order->id }}, 'dikonfirmasi')" class="text-sm bg-purple-500 hover:bg-purple-600 text-white py-1 px-2 rounded">Konfirmasi</button>
                                    @elseif ($order->status == 'dikonfirmasi')
                                        <button onclick="updateOrderStatus({{ $order->id }}, 'diproses')" class="text-sm bg-blue-500 hover:bg-blue-600 text-white py-1 px-2 rounded">Proses</button>
                                    @elseif ($order->status == 'diproses')
                                        <button onclick="updateOrderStatus({{ $order->id }}, 'selesai')" class="text-sm bg-green-500 hover:bg-green-600 text-white py-1 px-2 rounded">Selesai</button>
                                    @endif
                                    {{-- Add cancel button if needed --}}
                                    {{-- <button onclick="updateOrderStatus({{ $order->id }}, 'dibatalkan')" class="text-sm bg-red-500 hover:bg-red-600 text-white py-1 px-2 rounded ml-2">Batalkan</button> --}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-3 py-4 whitespace-nowrap text-sm text-gray-600 text-center">
                                    Tidak ada pesanan masuk terbaru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-center sm:text-right">
                <a href="/petugas/pesanan" class="text-primary hover:text-primary-dark font-medium flex items-center justify-center sm:justify-end">
                    Lihat Semua Pesanan Masuk
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 flex flex-col items-start smooth-transition">
                <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4a2 2 0 012 2v2h4a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2h2zm4 0H6v2h2V4zm8 0h-4v2h4V4z" clip-rule="evenodd"></path>
                    </svg>
                    Lihat Riwayat Tugas
                </h3>
                <p class="text-base text-gray-600 mb-4">
                    Lihat daftar semua pekerjaan yang telah Anda selesaikan.
                </p>
                <a href="/petugas/riwayat" class="w-full sm:w-auto bg-gray-100 text-gray-800 px-5 py-2 rounded-full font-semibold hover:bg-gray-200 transition duration-200 text-sm flex items-center justify-center">
                    Buka Riwayat
                </a>
            </div>

            <div class="bg-primary text-white rounded-2xl shadow-lg p-6 sm:p-8 flex flex-col items-start justify-center smooth-transition">
                <h3 class="text-xl sm:text-2xl font-bold mb-3 flex items-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zm-2 2a1 1 0 00-1 1v3a1 1 0 001 1h2a1 1 0 001-1V9a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    Pusat Bantuan
                </h3>
                <p class="text-base text-white/90 mb-4">
                    Temukan panduan atau hubungi admin jika ada masalah.
                </p>
                <a href="/petugas/bantuan" class="w-full sm:w-auto bg-white text-primary px-5 py-2 rounded-full font-semibold hover:bg-gray-100 transition duration-200 text-sm flex items-center justify-center">
                    Akses Bantuan
                </a>
            </div>
        </div>

    </div>

    {{-- Script untuk AJAX update status --}}
    <script>
        function updateOrderStatus(orderId, newStatus) {
            if (!confirm(`Apakah Anda yakin ingin mengubah status pesanan ini menjadi ${newStatus}?`)) {
                return;
            }

            fetch(`/petugas/pesanan/${orderId}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.reload(); // Refresh halaman untuk melihat perubahan
                } else {
                    alert('Gagal memperbarui status: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memperbarui status.');
            });
        }
    </script>
@endsection