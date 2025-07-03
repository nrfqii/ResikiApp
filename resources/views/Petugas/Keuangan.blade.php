@extends('layouts.main')

@section('title', 'Keuangan Petugas')
@section('subtitle', 'Laporan Pendapatan')

@section('content')
@php
    use Carbon\Carbon;
@endphp
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Income -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Total Pendapatan</h3>
            <p class="text-3xl font-bold text-primary">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            <p class="text-sm text-gray-500 mt-1">Seluruh pendapatan yang diperoleh</p>
        </div>

        <!-- Current Month Income -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Pendapatan Bulan Ini</h3>
            <p class="text-3xl font-bold text-primary">
                Rp {{ number_format($currentMonthIncome, 0, ',', '.') }}
            </p>
            <p class="text-sm text-gray-500 mt-1">Pendapatan bulan {{ now()->translatedFormat('F Y') }}</p>
        </div>

        <!-- Completed Orders This Month -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Pesanan Selesai</h3>
            <p class="text-3xl font-bold text-primary">{{ $currentMonthOrders->total() }}</p>
            <p class="text-sm text-gray-500 mt-1">Pesanan Selesai bulan ini</p>
        </div>
    </div>

    <!-- Monthly Income Chart -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Pendapatan Per Bulan</h3>
        <div class="h-64">
            <canvas id="monthlyIncomeChart"></canvas>
        </div>
    </div>

    <!-- Recent Completed Orders -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Pesanan Selesai Bulan Ini</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID Pesanan
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Paket
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pendapatan
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($currentMonthOrders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            #{{ $order->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ Carbon::parse($order->tanggal)->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->paket_jasa->nama_paket ?? $order->nama_paket ?? 'Custom' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-primary">
                            Rp {{ number_format($order->harga_paket, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            Tidak ada pesanan selesai bulan ini
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $currentMonthOrders->links() }}
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">Tambah Pendapatan</h3>
            <button onclick="hideEditModal()" class="text-gray-500 hover:text-gray-700">
                &times;
            </button>
        </div>
        
        <form id="editForm">
            @csrf
            <input type="hidden" id="order_id" name="order_id">
            <input type="hidden" id="current_amount" name="current_amount">
            
            <div class="mb-4">
                <label for="harga_paket" class="block text-sm font-medium text-gray-700 mb-1">
                    Jumlah Tambahan (Rp)
                </label>
                <input type="number" id="harga_paket" name="harga_paket" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary p-2 border"
                       min="1" required>
                <p class="text-xs text-gray-500 mt-1">Masukkan jumlah yang ingin ditambahkan</p>
            </div>
            
            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" onclick="hideEditModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-primary text-white rounded-md text-sm font-medium hover:bg-primary-dark flex items-center">
                    <span id="submit-text">Simpan</span>
                    <svg id="submit-spinner" class="hidden animate-spin ml-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Data
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('monthlyIncomeChart').getContext('2d');
        const monthlyData = @json($monthlyIncome);
        
        const months = monthlyData.map(item => `${item.month_name} ${item.year}`);
        const incomes = monthlyData.map(item => item.total);
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Pendapatan',
                    data: incomes,
                    backgroundColor: '#0ABAB5',
                    borderColor: '#088D88',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    });

</script>

@endsection