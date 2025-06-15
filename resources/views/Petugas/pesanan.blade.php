@extends('layouts.main')

@section('title', 'Pesanan Masuk')
@section('subtitle', 'Kelola pesanan yang menunggu dan dalam proses')

@section('content')
    <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6 flex items-center">
            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-primary mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
            </svg>
            Daftar Pesanan Masuk
        </h2>

        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
            <input type="text" placeholder="Cari ID Pesanan, Konsumen, atau Layanan..."
                   class="w-full sm:w-2/3 md:w-1/2 p-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 smooth-transition">
            <select class="w-full sm:w-auto p-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 smooth-transition">
                <option value="">Semua Status</option>
                <option value="menunggu konfirmasi">Menunggu Konfirmasi</option>
                <option value="dalam pengerjaan">Dalam Pengerjaan</option>
                <option value="dibatalkan">Dibatalkan</option>
            </select>
        </div>

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
                        <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
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
                    {{-- Loop melalui data pesanan masuk dari controller --}}
                    @forelse($orders as $order)
                        <tr>
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                #{{ $order->id }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $order->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600 hidden sm:table-cell">
                                {{ $order->service->name ?? 'N/A' }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600 hidden md:table-cell">
                                {{ \Carbon\Carbon::parse($order->scheduled_at)->format('d M Y, H:i') }} WIB
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap">
                                @if($order->status == 'menunggu konfirmasi')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Menunggu Konfirmasi
                                    </span>
                                @elseif($order->status == 'dalam pengerjaan')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Dalam Pengerjaan
                                    </span>
                                @elseif($order->status == 'selesai')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Selesai
                                    </span>
                                @elseif($order->status == 'dibatalkan')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Dibatalkan
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('order.detail', $order->id) }}" class="text-primary hover:text-primary-dark mr-3">Detail</a>
                                @if($order->status == 'menunggu konfirmasi')
                                    <button onclick="updateOrderStatus({{ $order->id }}, 'dalam pengerjaan')" class="text-xs bg-blue-500 hover:bg-blue-600 text-white py-1 px-2 rounded-full smooth-transition">Proses</button>
                                @elseif($order->status == 'dalam pengerjaan')
                                    <button onclick="updateOrderStatus({{ $order->id }}, 'selesai')" class="text-xs bg-green-500 hover:bg-green-600 text-white py-1 px-2 rounded-full smooth-transition">Selesai</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-3 py-4 text-center text-gray-500">Tidak ada pesanan masuk saat ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Contoh Paginasi (jika Anda menggunakan paginasi di controller) --}}
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>

    {{-- Script untuk update status (gunakan AJAX) --}}
    @push('scripts')
    <script>
        function updateOrderStatus(orderId, newStatus) {
            if (confirm(`Apakah Anda yakin ingin mengubah status pesanan #${orderId} menjadi "${newStatus.replace('_', ' ').toUpperCase()}"?`)) {
                fetch(`/api/petugas/pesanan/${orderId}/status`, { // Ganti dengan endpoint API Anda
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Penting untuk Laravel
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Status pesanan berhasil diperbarui!');
                        window.location.reload(); // Muat ulang halaman untuk melihat perubahan
                    } else {
                        alert('Gagal memperbarui status pesanan: ' + (data.message || 'Terjadi kesalahan.'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan jaringan atau server.');
                });
            }
        }
    </script>
    @endpush
@endsection