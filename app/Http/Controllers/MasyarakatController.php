<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Ulasan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // Tambahkan ini jika belum ada

class MasyarakatController extends Controller
{
    public function dashboard()
    {
        // Pastikan hanya user dengan role 'konsumen' yang bisa mengakses
        if (Auth::user()->role !== 'konsumen') {
            abort(403, 'Akses ditolak. Anda bukan konsumen.');
        }

        $userId = Auth::id();

        // Mengambil jumlah pesanan menunggu
        $pendingOrdersCount = Pesanan::where('user_id', $userId)
            ->where('status', Pesanan::STATUS_PENDING)
            ->count();

        // Mengambil jumlah pesanan selesai
        $completedOrdersCount = Pesanan::where('user_id', $userId)
            ->where('status', Pesanan::STATUS_SELESAI)
            ->count();

        // Mengambil jumlah ulasan 
        $reviewsCount = Ulasan::where('user_id', $userId)
            ->count();

        // Mengambil pesanan terbaru 
        $recentOrders = Pesanan::where('user_id', $userId)
            ->orderBy('tanggal', 'desc')
            ->get();

        // Melewatkan data ke view
        return view('Masyarakat.dashboard_masyarakat', compact(
            'pendingOrdersCount',
            'completedOrdersCount',
            'reviewsCount',
            'recentOrders'
        ));
    }
}