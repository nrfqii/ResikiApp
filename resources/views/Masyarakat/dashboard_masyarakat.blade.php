{{-- {{ dd($recentOrders) }} --}}
@extends('layouts.main')

@section('title', 'Dashboard Konsumen')
@section('subtitle', 'Ikhtisar aktivitas Anda dan layanan kebersihan')

@section('content')
    <div class="space-y-4 sm:space-y-6 lg:space-y-8">
        {{-- Bagian Selamat Datang dan Pesan Jasa Baru --}}
        <div
            class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 md:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between smooth-transition">
            <div class="mb-4 sm:mb-0 sm:mr-4">
                <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-2">Halo,
                    {{ auth()->user()->name ?? 'Pengguna' }}!</h2>
                <p class="text-sm sm:text-base text-gray-600 leading-relaxed max-w-md"> Selamat datang kembali di ResikiApp.
                    Di sini Anda bisa mengelola pesanan kebersihan Anda dengan mudah. </p>
            </div>
            <a href="{{ route('pesan.index') }}"
                class="w-full sm:w-auto bg-primary text-white px-4 py-2 sm:px-5 sm:py-2.5 rounded-full text-sm sm:text-base font-semibold hover:bg-primary-dark transform hover:scale-105 transition duration-200 shadow-md hover:shadow-xl flex items-center justify-center">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4">
                    </path>
                </svg>
                Pesan Jasa Baru
            </a>
        </div>

        {{-- Bagian Kartu Statistik --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <div
                class="bg-white rounded-2xl shadow-lg p-4 sm:p-5 border border-transparent hover:border-primary transform hover:scale-105 transition duration-300 smooth-transition flex items-center space-x-3">
                <div class="p-2 bg-yellow-100 rounded-full text-yellow-600 flex-shrink-0">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium">Pesanan Menunggu</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $pendingOrdersCount }}</p>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl shadow-lg p-4 sm:p-5 border border-transparent hover:border-primary transform hover:scale-105 transition duration-300 smooth-transition flex items-center space-x-3">
                <div class="p-2 bg-green-100 rounded-full text-green-600 flex-shrink-0">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium">Pesanan Selesai</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $completedOrdersCount }}</p>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl shadow-lg p-4 sm:p-5 border border-transparent hover:border-primary transform hover:scale-105 transition duration-300 smooth-transition flex items-center space-x-3">
                <div class="p-2 bg-blue-100 rounded-full text-blue-600 flex-shrink-0">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium">Ulasan Diberikan</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $reviewsCount }}</p>
                </div>
            </div>
        </div>

        {{-- Bagian Pesanan Terbaru Anda --}}
        <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6">
            <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 2a8 8 0 100 16 8 8 0 000-16zm-3 8a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm1 3a1 1 0 100 2h4a1 1 0 100-2H8z"
                        clip-rule="evenodd"></path>
                </svg>
                Pesanan Terbaru Anda
            </h3>
            @if ($recentOrders->isEmpty())
                <p class="text-gray-600 text-center py-4">Anda belum memiliki pesanan terbaru.</p>
            @else
                {{-- Tampilan Mobile --}}
                <div class="block md:hidden space-y-4">
                    @foreach ($recentOrders as $index => $order)
                        <div class="border border-gray-200 rounded-xl p-4">
                            <div class="flex justify-between items-center mb-2">
                                <p class="text-sm font-medium text-gray-900">No. {{ $index + 1 }}</p>
                                {{-- Changed from $order->id to $index + 1 --}}
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
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                            </div>
                            <p class="text-sm text-gray-600">{{ $order->nama_paket ?? $order->custom_request }}
                            </p>
                            <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($order->tanggal)->format('d F Y') }}
                            </p>
                            <button onclick="showOrderDetails({{ $order->id }})"
                                class="text-primary hover:text-primary-dark text-sm font-medium mt-2 inline-block">Detail</button>
                        </div>
                    @endforeach
                </div>
                {{-- Tampilan Desktop --}}
                <div class="hidden md:block overflow-x-auto custom-scrollbar -mx-4 sm:-mx-6 px-4 sm:px-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No.</th> {{-- Changed from ID Pesanan to No. --}}
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Layanan</th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                    Harga
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal</th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($recentOrders as $index => $order)
                                <tr>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $index + 1 }}</td> {{-- Changed from $order->id to $index + 1 --}}
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $order->nama_paket ?? $order->custom_request }}</td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600 hidden sm:table-cell">
                                        Rp {{ number_format($order->harga_paket, 0, ',', '.') }}
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($order->tanggal)->format('d F Y') }}</td>
                                    <td class="px-3 py-4 whitespace-nowrap">
                                        @php
                                            $statusClass = '';
                                            switch ($order->status) {
                                                case \App\Models\Pesanan::STATUS_PENDING:
                                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                                    break;
                                                case \App\Models\Pesanan::STATUS_DIPROSES:
                                                    $statusClass = 'bg-purple-100 text-purple-800';
                                                    break;
                                                case \App\Models\Pesanan::STATUS_SELESAI:
                                                    $statusClass = 'bg-green-100 text-green-800';
                                                    break;
                                                case \App\Models\Pesanan::STATUS_DIBATALKAN:
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
                                        <button onclick="showOrderDetails({{ $order->id }})"
                                            class="text-primary hover:text-primary-dark">Detail</button>
                                        @if ($order->status === 'diproses')
                                            <button
                                                onclick="showConfirmationModal({{ $order->id }}, 'selesai', 'Selesaikan')"
                                                class="px-2 text-success hover:text-success-dark  ">
                                                Tandai Selesai
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Bagian Berikan Ulasan & Butuh Bantuan --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
            <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 flex flex-col items-start smooth-transition">
                <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                        </path>
                    </svg>
                    Berikan Ulasan Anda
                </h3>
                <p class="text-sm sm:text-base text-gray-600 mb-3">
                    Bagikan pengalaman Anda menggunakan layanan kami. Ulasan Anda sangat berarti!
                </p>
                <a href="{{ route('ulasan.index') }}"
                    class="w-full sm:w-auto bg-gray-100 text-gray-800 px-4 py-2 rounded-full font-semibold hover:bg-gray-200 transition duration-200 text-sm flex items-center justify-center">
                    Tulis Ulasan
                </a>
            </div>

            <div
                class="bg-primary text-white rounded-2xl shadow-lg p-4 sm:p-6 flex flex-col items-start justify-center smooth-transition">
                <h3 class="text-lg sm:text-xl font-bold mb-3 flex items-center">
                    <svg class="w-5 h-5 text-white mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Butuh Bantuan?
                </h3>
                <p class="text-sm sm:text-base text-white/90 mb-3">
                    Jangan ragu menghubungi kami jika Anda memiliki pertanyaan atau kendala.
                </p>
                <a href="https://wa.me/62895386977117?text=Halo%20Admin%20ResikiApp%2C%20saya%20butuh%20bantuan%20terkait%20pesanan%20saya."
                    target="_blank"
                    class="w-full sm:w-auto bg-white text-primary px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition duration-200 text-sm flex items-center justify-center">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
    <!-- Modal Konfirmasi -->
    <div id="confirmationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2" id="modal-title">Konfirmasi Aksi</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500" id="modal-message">Apakah Anda yakin?</p>

                </div>


                <div class="items-center px-4 py-3">
                    <button id="confirmButton"
                        class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Ya
                    </button>
                    <button id="cancelButton"
                        class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-24 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Loading Modal -->
    <div id="loadingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-1/2 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white transform -translate-y-1/2">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                    <svg class="animate-spin h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Memproses...</h3>
                <p class="text-sm text-gray-500 mt-2">Mohon tunggu, sedang memperbarui status pesanan.</p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Fungsi bantu untuk reset elemen map
            function resetLeafletMapContainer(id) {
                const container = L.DomUtil.get(id);
                if (container != null) {
                    container._leaflet_id = null; // ini penting!
                    container.innerHTML = ""; // bersihkan isi div
                }
            }

            let currentOrderId = null;
            let currentStatus = null;
            let currentAction = null;

            function showConfirmationModal(orderId, newStatus, actionName) {
                currentOrderId = orderId;
                currentStatus = newStatus;
                currentAction = actionName;

                const statusMessages = {
                    'selesai': 'Apakah Anda yakin pesanan ini sudah selesai dikerjakan?'
                };

                const buttonColors = {
                    'selesai': 'bg-green-500 hover:bg-green-600'
                };

                document.getElementById('modal-title').textContent = `Konfirmasi ${actionName}`;
                document.getElementById('modal-message').textContent = statusMessages[newStatus] || 'Apakah Anda yakin?';

                const confirmButton = document.getElementById('confirmButton');
                confirmButton.textContent = actionName;
                confirmButton.className =
                    `px-4 py-2 text-white text-base font-medium rounded-md w-24 mr-2 focus:outline-none focus:ring-2 ${buttonColors[newStatus]}`;

                document.getElementById('confirmationModal').classList.remove('hidden');
            }

            function hideConfirmationModal() {
                document.getElementById('confirmationModal').classList.add('hidden');
                // Don't reset the variables here, keep them for the confirmation
            }

            function showLoadingModal() {
                document.getElementById('loadingModal').classList.remove('hidden');
            }

            function hideLoadingModal() {
                document.getElementById('loadingModal').classList.add('hidden');
            }

            function updateOrderStatus() {
                console.log('updateOrderStatus called with:', currentOrderId, currentStatus);

                if (!currentOrderId || !currentStatus) {
                    console.error('Missing data:', {
                        currentOrderId,
                        currentStatus
                    });
                    alert('Terjadi kesalahan sistem: Data pesanan tidak valid');
                    return;
                }

                hideConfirmationModal();
                showLoadingModal();

                let csrfToken = null;
                const metaToken = document.querySelector('meta[name="csrf-token"]');
                if (metaToken) {
                    csrfToken = metaToken.getAttribute('content');
                } else {
                    const tokenInput = document.querySelector('input[name="_token"]');
                    if (tokenInput) {
                        csrfToken = tokenInput.value;
                    }
                }

                if (!csrfToken) {
                    console.error('CSRF token not found');
                    hideLoadingModal();
                    showErrorMessage('Token keamanan tidak ditemukan. Silakan refresh halaman.');
                    return;
                }

                // Panggil fungsi update ke server
                sendStatusUpdate(csrfToken); // untuk konsumen, tidak perlu koordinat
            }

            function sendStatusUpdate(csrfToken) {
                // Siapkan payload dasar
                const payload = {
                    status: currentStatus,
                };


                // Jika status dikonfirmasi dan ada input harga

                fetch(`/konsumen/pesanan/${currentOrderId}/status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        console.log('Response headers:', response.headers);

                        return response.text().then(text => {
                            console.log('Response text:', text);

                            if (!response.ok) {
                                try {
                                    const errorData = JSON.parse(text);
                                    throw new Error(
                                        `HTTP ${response.status}: ${errorData.message || errorData.error || 'Server Error'}`
                                    );
                                } catch (parseError) {
                                    throw new Error(`HTTP ${response.status}: ${text.substring(0, 200)}...`);
                                }
                            }

                            try {
                                return JSON.parse(text);
                            } catch (parseError) {
                                throw new Error('Invalid JSON response from server');
                            }
                        });
                    })
                    .then(data => {
                        hideLoadingModal();
                        console.log('Success response:', data);

                        if (data.success) {
                            showSuccessMessage(data.message || 'Status pesanan berhasil diperbarui!');

                            if (currentStatus === 'selesai') {
                                const row = document.getElementById(`order-row-${currentOrderId}`);
                                if (row) {
                                    row.style.transition = 'opacity 0.5s ease-out';
                                    row.style.opacity = '0';
                                    setTimeout(() => {
                                        row.remove();
                                    }, 500);
                                }
                            } else {
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);
                            }
                        } else {
                            showErrorMessage(data.message || 'Gagal memperbarui status pesanan');
                        }
                    })
                    .catch(error => {
                        hideLoadingModal();
                        console.error('Full error details:', error);
                        showErrorMessage(`Error: ${error.message}`);
                    })
                    .finally(() => {
                        currentOrderId = null;
                        currentStatus = null;
                        currentAction = null;
                    });
            }

            function showSuccessMessage(message) {
                const alertDiv = document.createElement('div');
                alertDiv.className =
                    'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300 translate-x-full';
                alertDiv.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            ${message}
        </div>
    `;

                document.body.appendChild(alertDiv);

                setTimeout(() => {
                    alertDiv.classList.remove('translate-x-full');
                }, 100);

                setTimeout(() => {
                    alertDiv.classList.add('translate-x-full');
                    setTimeout(() => {
                        document.body.removeChild(alertDiv);
                    }, 300);
                }, 3000);
            }

            function showErrorMessage(message) {
                const alertDiv = document.createElement('div');
                alertDiv.className =
                    'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300 translate-x-full';
                alertDiv.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            ${message}
        </div>
    `;

                document.body.appendChild(alertDiv);

                setTimeout(() => {
                    alertDiv.classList.remove('translate-x-full');
                }, 100);

                setTimeout(() => {
                    alertDiv.classList.add('translate-x-full');
                    setTimeout(() => {
                        document.body.removeChild(alertDiv);
                    }, 300);
                }, 4000);
            }

            document.getElementById('confirmButton').addEventListener('click', updateOrderStatus);
            document.getElementById('cancelButton').addEventListener('click', hideConfirmationModal);
        </script>
    @endpush
@endsection
