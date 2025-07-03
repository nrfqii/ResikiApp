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

        {{-- Formulir Filter --}}
        <form method="GET" action="{{ route('petugas.riwayat') }}" class="mb-6">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" placeholder="Cari ID Pesanan, Konsumen, atau Layanan..."
                        value="{{ request('search') }}"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 smooth-transition">
                </div>
                <div class="w-full sm:w-48">
                    <input type="month" name="bulan" value="{{ request('bulan') }}"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 smooth-transition">
                </div>
                <div class="w-full sm:w-48">
                    <select name="status"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 smooth-transition">
                        <option value="">Semua Status</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan
                        </option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="bg-primary hover:bg-primary-dark text-white px-4 py-3 rounded-lg smooth-transition">
                        Filter
                    </button>
                    <a href="{{ route('petugas.riwayat') }}"
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
                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                            Harga
                        </th>
                        <th scope="col"
                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                            Tanggal Selesai / Dibatalkan
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
                        {{-- Menghapus $index karena ID Pesanan sudah ada --}}
                        <tr>
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
                                {{-- Pastikan fungsi showOrderDetails ini mengarah ke detail riwayat pesanan, bukan pesanan aktif --}}
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

        {{-- Paginasi --}}
        <div class="mt-6">
            {{ $historicalOrders->appends(request()->query())->links() }}
        </div>
    </div>

@endsection
