    @extends('layouts.main')

    @section('title', 'Pesanan Masuk')
    @section('subtitle', 'Kelola pesanan yang menunggu dan dalam proses')

    @section('content')
        <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6 flex items-center">
                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-primary mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                        clip-rule="evenodd"></path>
                </svg>
                Daftar Pesanan Masuk
            </h2>

            <form method="GET" action="{{ route('petugas.pesanan') }}" class="mb-6">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" placeholder="Cari ID Pesanan, Konsumen, atau Layanan..."
                            value="{{ request('search') }}"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 smooth-transition">
                    </div>
                    <div class="w-full sm:w-48">
                        <select name="status"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 smooth-transition">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="dikonfirmasi" {{ request('status') == 'dikonfirmasi' ? 'selected' : '' }}>
                                Dikonfirmasi</option>
                            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses
                            </option>
                        </select>
                    </div>
                    <div class="w-full sm:w-48">
                        <input type="month" name="bulan" value="{{ request('bulan') }}"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 smooth-transition">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit"
                            class="bg-primary hover:bg-primary-dark text-white px-4 py-3 rounded-lg smooth-transition">
                            Filter
                        </button>
                        <a href="{{ route('petugas.pesanan') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-3 rounded-lg smooth-transition">
                            Reset
                        </a>
                    </div>
                </div>
            </form>

            <div class="overflow-x-auto custom-scrollbar -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No.
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
                                class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                Harga
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
                        @forelse($orders as $index => $order)
                            {{-- Tetap menggunakan $orders --}}
                            <tr id="order-row-{{ $order->id }}" data-harga="{{ $order->harga_paket }}">
                                <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $order->id }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $order->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600 hidden sm:table-cell">
                                    {{ $order->nama_paket ?? $order->custom_request }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600 hidden sm:table-cell">
                                    Rp {{ number_format($order->harga_paket, 0, ',', '.') }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600 hidden md:table-cell">
                                    {{ \Carbon\Carbon::parse($order->tanggal)->format('d M Y') }}, {{ $order->waktu }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap">
                                    @if ($order->status == 'pending')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Menunggu Konfirmasi
                                        </span>
                                    @elseif($order->status == 'dikonfirmasi')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Dikonfirmasi
                                        </span>
                                    @elseif($order->status == 'diproses')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                            Diproses
                                        </span>
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="#" onclick="showOrderDetails({{ $order->id }})"
                                            class="text-primary hover:text-primary-dark mr-3">
                                            detail
                                        </a>

                                        {{-- old btn --}}
                                        @if ($order->status == 'pending')
                                            <button
                                                onclick="showConfirmationModal({{ $order->id }}, 'dikonfirmasi', 'Terima')"
                                                class="text-green-600 hover:text-green-800" title="Terima">
                                                konfirmasi
                                            </button>
                                            <button
                                                onclick="showConfirmationModal({{ $order->id }}, 'dibatalkan', 'Tolak')"
                                                clon="text-red-600 hover:text-red-800" title="Tolak">
                                                tolak
                                            </button>
                                        @elseif($order->status == 'dikonfirmasi')
                                            <button
                                                onclick="showConfirmationModal({{ $order->id }}, 'diproses', 'Mulai Proses')"
                                                class="text-blue-600 hover:text-blue-800" title="Mulai Proses">
                                                proses
                                            </button>
                                        @elseif($order->status == 'diproses')
                                            <button
                                                onclick="showConfirmationModal({{ $order->id }}, 'selesai', 'Selesaikan')"
                                                class="text-green-600 hover:text-green-800" title="Selesai">
                                                selesai
                                            </button>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-3 py-4 text-center text-gray-500">
                                    Tidak ada pesanan masuk saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        </div>

        <!-- Modal Konfirmasi -->
        <div id="confirmationModal"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
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

                        <!-- Harga hanya jika konfirmasi -->
                        <div id="customPriceInputContainer" class="hidden mt-3 text-left">
                            <label for="customPriceInput" class="block text-sm font-medium text-gray-700">Harga
                                Paket</label>
                            <input type="number" id="customPriceInput" name="custom_price" min="0"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                                placeholder="Masukkan harga (Rp)">
                        </div>

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
                // Variables for confirmation modal
                let currentOrderId = null;
                let currentStatus = null;
                let currentAction = null;

                function showConfirmationModal(orderId, newStatus, actionName) {
                    currentOrderId = orderId;
                    currentStatus = newStatus;
                    currentAction = actionName;

                    const statusMessages = {
                        'dikonfirmasi': 'Apakah Anda yakin ingin menerima pesanan ini?',
                        'dibatalkan': 'Apakah Anda yakin ingin menolak pesanan ini?',
                        'diproses': 'Apakah Anda yakin ingin memulai proses pesanan ini?',
                        'selesai': 'Apakah Anda yakin pesanan ini sudah selesai dikerjakan?'
                    };

                    const buttonColors = {
                        'dikonfirmasi': 'bg-green-500 hover:bg-green-600',
                        'dibatalkan': 'bg-red-500 hover:bg-red-600',
                        'diproses': 'bg-blue-500 hover:bg-blue-600',
                        'selesai': 'bg-green-500 hover:bg-green-600'
                    };

                    document.getElementById('modal-title').textContent = `Konfirmasi ${actionName}`;
                    document.getElementById('modal-message').textContent = statusMessages[newStatus] || 'Apakah Anda yakin?';

                    const confirmButton = document.getElementById('confirmButton');
                    confirmButton.textContent = actionName;
                    confirmButton.className =
                        `px-4 py-2 text-white text-base font-medium rounded-md w-24 mr-2 focus:outline-none focus:ring-2 ${buttonColors[newStatus]}`;

                    const priceContainer = document.getElementById('customPriceInputContainer');
                    const priceInput = document.getElementById('customPriceInput');

                    if (newStatus === 'dikonfirmasi') {
                        // Ambil harga dari atribut HTML baris
                        const row = document.getElementById(`order-row-${orderId}`);
                        console.log('Found row:', row); // Debug log
                        const harga = row?.dataset.harga || 0;
                        console.log('Harga found:', harga); // Debug log

                        priceContainer.classList.remove('hidden');
                        priceInput.value = harga;
                    } else {
                        priceContainer.classList.add('hidden');
                        priceInput.value = '';
                    }

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
                    console.log('updateOrderStatus called with:', currentOrderId, currentStatus); // Debug log

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

                    // Get CSRF token from meta tag or try from form
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

                    // Ambil input harga jika status dikonfirmasi
                    let customPrice = null;
                    if (currentStatus === 'dikonfirmasi') {
                        const priceInput = document.getElementById('customPriceInput');
                        if (priceInput && priceInput.value.trim() !== '') {
                            customPrice = parseInt(priceInput.value);
                            if (isNaN(customPrice)) {
                                hideLoadingModal();
                                showErrorMessage('Harga tidak valid.');
                                return;
                            }
                        }
                    }

                    if (currentStatus === 'diproses' && navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            sendStatusUpdate(csrfToken, position.coords.latitude, position.coords.longitude, customPrice);
                        }, function(error) {
                            hideLoadingModal();
                            showErrorMessage('Gagal mendapatkan lokasi petugas. Pastikan izin lokasi diaktifkan.');
                        });
                    } else {
                        sendStatusUpdate(csrfToken, null, null, customPrice);
                    }
                }


                function sendStatusUpdate(csrfToken, latitude, longitude) {
                    // Siapkan payload dasar
                    const payload = {
                        status: currentStatus,
                        latitude: latitude,
                        longitude: longitude,
                        harga_paket: currentStatus === 'dikonfirmasi' ? document.getElementById('customPriceInput')?.value : null
                    };

                    // Jika status dikonfirmasi dan ada input harga
                    if (currentStatus === 'dikonfirmasi') {
                        const priceInput = document.getElementById('customPriceInput');
                        if (priceInput && priceInput.value.trim() !== '') {
                            const parsedPrice = parseInt(priceInput.value);
                            if (!isNaN(parsedPrice)) {
                                payload.harga_paket = parsedPrice;
                            }
                        }
                    }

                    fetch(`/petugas/pesanan/${currentOrderId}/status`, {
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

                                if (currentStatus === 'dibatalkan' || currentStatus === 'selesai') {
                                    const row = document.getElementById(`order-row-${currentOrderId}`);
                                    if (row) {
                                        row.style.transition = 'opacity 0.5s ease-out';
                                        row.style.opacity = '0';
                                        setTimeout(() => {
                                            row.remove();
                                            checkEmptyTable();
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

                function checkEmptyTable() {
                    const tbody = document.querySelector('tbody');
                    const rows = tbody.querySelectorAll('tr:not([id*="empty-row"])');

                    if (rows.length === 0) {
                        tbody.innerHTML = `
            <tr id="empty-row">
                <td colspan="6" class="px-3 py-4 text-center text-gray-500">
                    Tidak ada pesanan masuk saat ini.
                </td>
            </tr>
        `;
                    }
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

                // Event listeners - Make sure these are set up after DOM is loaded
                document.addEventListener('DOMContentLoaded', function() {
                    // Event listeners for modal buttons
                    const confirmButton = document.getElementById('confirmButton');
                    const cancelButton = document.getElementById('cancelButton');

                    if (confirmButton) {
                        confirmButton.addEventListener('click', updateOrderStatus);
                    }

                    if (cancelButton) {
                        cancelButton.addEventListener('click', hideConfirmationModal);
                    }

                    // Close modal when clicking outside
                    const confirmationModal = document.getElementById('confirmationModal');
                    if (confirmationModal) {
                        confirmationModal.addEventListener('click', function(e) {
                            if (e.target === this) {
                                hideConfirmationModal();
                            }
                        });
                    }

                    // Close modal with Escape key
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                            const confirmationModal = document.getElementById('confirmationModal');
                            if (confirmationModal && !confirmationModal.classList.contains('hidden')) {
                                hideConfirmationModal();
                            }
                        }
                    });
                });
            </script>
        @endpush
    @endsection
