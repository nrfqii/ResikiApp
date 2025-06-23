@extends('layouts.main')

@section('title', 'Dashboard Petugas')
@section('subtitle', 'Ikhtisar pesanan masuk dan tugas Anda')

@section('content')
    <div class="space-y-6 lg:space-y-8"> {{-- Konsisten dengan spacing responsif --}}

        <div
            class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 md:p-10 flex flex-col sm:flex-row items-start sm:items-center justify-between smooth-transition">
            <div class="mb-4 sm:mb-0 sm:mr-6">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-800 mb-2">Halo, Petugas
                    {{ auth()->user()->name ?? '' }}!</h2>
                <p class="text-base sm:text-lg text-gray-600 leading-relaxed max-w-xl">
                    Di sini Anda dapat melihat pesanan masuk, mengelola jadwal, dan memperbarui status pekerjaan.
                </p>
            </div>
            <a href="/petugas/pesanan"
                class="w-full sm:w-auto bg-primary text-white px-5 py-2.5 sm:px-6 sm:py-3 rounded-full text-base sm:text-lg font-semibold hover:bg-primary-dark transform hover:scale-105 transition duration-200 shadow-md hover:shadow-xl flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                    </path>
                </svg>
                Lihat Pesanan Masuk
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <div
                class="bg-white rounded-2xl shadow-lg p-5 sm:p-6 border border-transparent hover:border-primary transform hover:scale-105 transition duration-300 smooth-transition flex items-center space-x-4">
                <div class="p-3 bg-red-100 rounded-full text-red-600 flex-shrink-0">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7V6a3 3 0 116 0v1M9 7h6l1 10H8L9 7z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm sm:text-base text-gray-500 font-medium">Pesanan Baru</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $newOrdersCount ?? 0 }}</p>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl shadow-lg p-5 sm:p-6 border border-transparent hover:border-primary transform hover:scale-105 transition duration-300 smooth-transition flex items-center space-x-4">
                <div class="p-3 bg-blue-100 rounded-full text-blue-600 flex-shrink-0">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm sm:text-base text-gray-500 font-medium">Sedang Diproses</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $inProgressOrdersCount ?? 0 }}</p>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl shadow-lg p-5 sm:p-6 border border-transparent hover:border-primary transform hover:scale-105 transition duration-300 smooth-transition flex items-center space-x-4">
                <div class="p-3 bg-green-100 rounded-full text-green-600 flex-shrink-0">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
                    <path fill-rule="evenodd"
                        d="M10 2a8 8 0 100 16 8 8 0 000-16zm-3 8a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm1 3a1 1 0 100 2h4a1 1 0 100-2H8z"
                        clip-rule="evenodd"></path>
                </svg>
                Pesanan Masuk Terbaru
            </h3>
            <div class="overflow-x-auto custom-scrollbar -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                NO.
                            </th>
                            <th scope="col"
                                class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Konsumen
                            </th>
                            <th scope="col"
                                class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Layanan
                            </th>
                            <th scope="col"
                                class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                Tanggal & Waktu
                            </th>
                            <th scope="col"
                                class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($latestIncomingOrders as $index => $order)
                            <tr>
                                <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $index + 1}}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $order->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $order->nama_paket ?? ($order->paket->nama_paket ?? $order->custom_request) }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600 hidden md:table-cell">
                                    {{ \Carbon\Carbon::parse($order->tanggal)->format('d F Y') }},
                                    {{ \Carbon\Carbon::parse($order->waktu)->format('H:i') }} WIB
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
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="#" onclick="showOrderDetails({{ $order->id }})"
                                        class="text-primary hover:text-primary-dark mr-3">Detail</a>
                                    {{-- @if ($order->status == 'pending')
                                    @elseif ($order->status == 'dikonfirmasi')
                                        <button onclick="updateOrderStatus({{ $order->id }}, 'diproses')"
                                            class="text-sm bg-purple-500 hover:bg-purple-600 text-white py-1 px-2 rounded">Proses</button>
                                    @elseif ($order->status == 'diproses')
                                        <button onclick="updateOrderStatus({{ $order->id }}, 'selesai')"
                                            class="text-sm bg-green-500 hover:bg-green-600 text-white py-1 px-2 rounded">Selesai</button>
                                    @endif --}}
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
                <a href="/petugas/pesanan"
                    class="text-primary hover:text-primary-dark font-medium flex items-center justify-center sm:justify-end">
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
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 012-2h4a2 2 0 012 2v2h4a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2h2zm4 0H6v2h2V4zm8 0h-4v2h4V4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Lihat Riwayat Tugas
                </h3>
                <p class="text-base text-gray-600 mb-4">
                    Lihat daftar semua pekerjaan yang telah Anda selesaikan.
                </p>
                <a href="/petugas/riwayat"
                    class="w-full sm:w-auto bg-gray-100 text-gray-800 px-5 py-2 rounded-full font-semibold hover:bg-gray-200 transition duration-200 text-sm flex items-center justify-center">
                    Buka Riwayat
                </a>
            </div>

            <div
                class="bg-primary text-white rounded-2xl shadow-lg p-6 sm:p-8 flex flex-col items-start justify-center smooth-transition">
                <h3 class="text-xl sm:text-2xl font-bold mb-3 flex items-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zm-2 2a1 1 0 00-1 1v3a1 1 0 001 1h2a1 1 0 001-1V9a1 1 0 00-1-1H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Pusat Bantuan
                </h3>
                <p class="text-base text-white/90 mb-4">
                    Temukan panduan atau hubungi admin jika ada masalah.
                </p>
                {{-- Mengarahkan ke WhatsApp dengan nomor admin --}}
                <a href="https://wa.me/62895386977117" target="_blank"
                    class="w-full sm:w-auto bg-white text-primary px-5 py-2 rounded-full font-semibold hover:bg-gray-100 transition duration-200 text-sm flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        {{-- SVG Icon WhatsApp (Anda bisa menggantinya dengan ikon WhatsApp yang lebih sesuai jika punya) --}}
                        <path
                            d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.4.92 4.97l-1.3 4.74 4.86-1.28c1.47.4 3.03.62 4.43.62h.003c5.46 0 9.91-4.45 9.91-9.91s-4.45-9.91-9.91-9.91zm.003 1.95c4.32 0 7.82 3.5 7.82 7.82s-3.5 7.82-7.82 7.82c-1.37 0-2.67-.36-3.83-1.04l-.27-.16-2.81.74.75-2.73-.18-.28c-.73-1.12-1.14-2.42-1.14-3.79 0-4.32 3.5-7.82 7.82-7.82zm3.765 10.37c-.12-.06-.7-.34-.81-.38-.11-.04-.19-.06-.27.06-.09.12-.34.38-.41.46-.08.09-.16.1-.28.04-.11-.06-.47-.17-1.12-.69-.82-.62-1.37-1.37-1.53-1.63-.16-.26-.01-.38.07-.46.07-.07.16-.18.23-.29.07-.11.07-.19.05-.26-.02-.07-.09-.2-.18-.46-.09-.26-.18-.22-.25-.22-.06 0-.13-.01-.2-.01-.73.01-1.28.36-1.74.8-1.5 1.45-.63 2.87.21 3.56.84.7 1.8 1.05 2.89 1.05 1.07 0 2.05-.29 2.75-.72.6-.37.98-.6.13-1.03z">
                        </path>
                    </svg>
                    Akses Bantuan via WhatsApp
                </a>
            </div>
        </div>
        {{-- Pop-up Modal for Order Details --}}
    </div>
    <div id="orderDetailModal"
        class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50 hidden">
        <div
            class="bg-white rounded-2xl shadow-xl w-full max-w-md md:max-w-lg lg:max-w-xl p-6 sm:p-8 relative transform transition-all duration-300">
            <button onclick="hideOrderDetails()"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>

            <div id="loadingSpinner" class="py-8 flex justify-center">
                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary"></div>
            </div>

            <div id="errorMessage" class="hidden py-8 text-center text-red-500">
                Gagal memuat detail pesanan. Silakan coba lagi.
            </div>

            <div id="modalContent" class="hidden">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">Detail Pesanan <span
                        id="modalOrderId"></span></h3>

                <div class="space-y-4 text-gray-700">
                    <div>
                        <p class="font-semibold text-gray-600">Konsumen:</p>
                        <p id="modalCustomerName" class="text-lg"></p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-600">Layanan:</p>
                        <p id="modalService" class="text-lg"></p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-600">Tanggal & Waktu:</p>
                        <p id="modalDateTime" class="text-lg"></p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-600">Alamat:</p>
                        <p id="modalAddress" class="text-lg"></p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-600">Catatan:</p>
                        <p id="modalNotes" class="text-lg italic"></p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-600">Status:</p>
                        <span id="modalStatus"
                            class="px-3 py-1 inline-flex text-base leading-5 font-semibold rounded-full"></span>
                    </div>
                    <div id="modalPetugasInfo" class="hidden">
                        <p class="font-semibold text-gray-600">Ditangani oleh:</p>
                        <p id="modalPetugasName" class="text-lg"></p>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button onclick="hideOrderDetails()"
                        class="bg-gray-200 text-gray-800 px-6 py-2 rounded-full font-semibold hover:bg-gray-300 transition duration-200">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk AJAX update status --}}
    <script>
        // Function to show order details in modal
        function showOrderDetails(orderId) {
            const modal = document.getElementById('orderDetailModal');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const errorMessage = document.getElementById('errorMessage');
            const modalContent = document.getElementById('modalContent');

            // Show modal and loading state
            modal.classList.remove('hidden');
            loadingSpinner.classList.remove('hidden');
            errorMessage.classList.add('hidden');
            modalContent.classList.add('hidden');

            // Fetch order details
            fetch(`/petugas/pesanan/${orderId}/detail-json`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(order => {
                    // Hide loading spinner and show content
                    loadingSpinner.classList.add('hidden');
                    modalContent.classList.remove('hidden');

                    // Populate modal with order data
                    document.getElementById('modalOrderId').textContent = '#' + order.id;
                    document.getElementById('modalCustomerName').textContent = order.user.name || 'N/A';
                    document.getElementById('modalService').textContent = (order.custom_request && order.custom_request
                            .trim() !== '') ?
                        order.custom_request :
                        (order.paket_jasa?.nama_paket || 'N/A');
                    document.getElementById('modalDateTime').textContent = `${order.tanggal_formatted}, ${order.waktu}`;
                    document.getElementById('modalAddress').textContent = order.alamat_lokasi || 'Tidak ada alamat';
                    document.getElementById('modalNotes').textContent = order.catatan || 'Tidak ada catatan';

                    // Set status with appropriate color
                    const statusElement = document.getElementById('modalStatus');
                    statusElement.textContent = order.status_label;
                    statusElement.className = 'px-3 py-1 inline-flex text-base leading-5 font-semibold rounded-full ' +
                        order.status_color;

                    // Show petugas info if available
                    if (order.petugas) {
                        document.getElementById('modalPetugasInfo').classList.remove('hidden');
                        document.getElementById('modalPetugasName').textContent = order.petugas.name;
                    } else {
                        document.getElementById('modalPetugasInfo').classList.add('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error fetching order details:', error);
                    loadingSpinner.classList.add('hidden');
                    errorMessage.classList.remove('hidden');
                });
        }

        // Function to hide order details modal
        function hideOrderDetails() {
            document.getElementById('orderDetailModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('orderDetailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideOrderDetails();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('orderDetailModal').classList.contains('hidden')) {
                hideOrderDetails();
            }
        });

        // Function to update order status
        function updateOrderStatus(orderId, newStatus) {
            if (!confirm(`Apakah Anda yakin ingin mengubah status pesanan ini menjadi ${newStatus}?`)) {
                return;
            }

            fetch(`/petugas/pesanan/${orderId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.reload();
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
