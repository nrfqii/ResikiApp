{{-- {{ dd($historicalOrders) }} --}}
@extends('layouts.main')

@section('title', 'Riwayat Pesanan')
@section('subtitle', 'Lihat semua riwayat tugas Anda')

@section('content')
    <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6 flex items-center">
            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-primary mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm-3-5a1 1 0 112 0v1a1 1 0 11-2 0v-1zm3-6a1 1 0 011 1v4a1 1 0 11-2 0V8a1 1 0 011-1z"
                    clip-rule="evenodd"></path>
            </svg>
            Riwayat Tugas
        </h2>

        <div
            class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
            <input type="text" placeholder="Cari ID Pesanan atau Konsumen..."
                class="w-full sm:w-2/3 md:w-1/2 p-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 smooth-transition">
            <input type="date"
                class="w-full sm:w-auto p-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 smooth-transition">
            <select
                class="w-full sm:w-auto p-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 smooth-transition">
                <option value="">Semua Status</option>
                <option value="selesai">Selesai</option>
                <option value="dibatalkan">Dibatalkan</option>
            </select>
        </div>

        <div class="overflow-x-auto custom-scrollbar -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID Pesanan
                        </th>
                        <th scope="col"
                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Konsumen
                        </th>
                        <th scope="col"
                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                            Layanan
                        </th>
                        <th scope="col"
                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                            Tanggal Selesai
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
                    {{-- Loop melalui data riwayat pesanan dari controller --}}
                    @forelse($historicalOrders as $order)
                        <tr>
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                #{{ $order->id }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $order->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600 hidden sm:table-cell">
                                {{ $order->nama_paket ?? 'N/A' }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600 hidden md:table-cell">
                                {{ \Carbon\Carbon::parse($order->updated_at)->format('d M Y, H:i') }} WIB
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap">
                                @if ($order->status == 'selesai')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Selesai
                                    </span>
                                @elseif($order->status == 'dibatalkan')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Dibatalkan
                                    </span>
                                @else
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="#" onclick="showOrderDetails({{ $order->id }})"
                                    class="text-primary hover:text-primary-dark mr-3">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-3 py-4 text-center text-gray-500">Tidak ada riwayat pesanan yang
                                ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Contoh Paginasi --}}
        <div class="mt-6">
            {{ $historicalOrders->links() }}
        </div>
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
                    document.getElementById('modalService').textContent = order.paket_jasa?.nama_paket || order
                        .custom_request || 'N/A';
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
