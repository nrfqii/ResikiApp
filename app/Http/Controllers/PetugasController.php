<?php

namespace App\Http\Controllers;

use App\Models\Pesanan; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 
use App\Models\User; 
use App\Models\PaketJasa; 

class PetugasController extends Controller
{

    public function dashboard()
    {
        if (Auth::user()->role !== 'petugas') {
            abort(403, 'Akses hanya untuk petugas.');
        }

        $newOrdersCount = Pesanan::where('status', Pesanan::STATUS_PENDING)->count();
        $inProgressOrdersCount = Pesanan::whereIn('status', [Pesanan::STATUS_DIKONFIRMASI, Pesanan::STATUS_DIPROSES])->count(); 

        // Pesanan selesai hari ini
        $completedTodayOrdersCount = Pesanan::where('status', Pesanan::STATUS_SELESAI)
                                            ->whereDate('updated_at', Carbon::today())
                                            ->count();

        $latestIncomingOrders = Pesanan::with(['user', 'paket']) 
                                            ->whereIn('status', [Pesanan::STATUS_PENDING, Pesanan::STATUS_DIKONFIRMASI, Pesanan::STATUS_DIPROSES]) // Status yang relevan untuk pesanan masuk
                                            ->orderBy('tanggal', 'asc') // Urutkan berdasarkan tanggal & waktu
                                            ->orderBy('waktu', 'asc')
                                            ->limit(5) // Ambil 5 terbaru
                                            ->get();

        // Mengirim data ke view dashboard
        return view('petugas.dashboard_petugas', compact(
            'newOrdersCount',
            'inProgressOrdersCount',
            'completedTodayOrdersCount',
            'latestIncomingOrders' // Data tabel pesanan terbaru di dashboard
        ));
    }

    /**
     * Memperbarui status pesanan.
     */
    public function updateStatus(Request $request, $id)
    {
        // Memastikan hanya pengguna dengan peran 'petugas' yang bisa mengakses
        if (Auth::user()->role !== 'petugas') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        $pesanan = Pesanan::findOrFail($id);

        // Validasi status baru
        // Pastikan nilai 'in' sesuai dengan ENUM di database Anda: 'pending', 'dikonfirmasi', 'diproses', 'selesai', 'dibatalkan'
        $request->validate([
            'status' => 'required|string|in:pending,dikonfirmasi,diproses,selesai,dibatalkan'
        ]);

        $pesanan->update([
            'status' => $request->status,
            'petugas_id' => Auth::id() // Memperbarui petugas_id dengan ID petugas yang sedang login
        ]);

        return response()->json(['success' => true, 'message' => 'Status pesanan berhasil diperbarui.']);
    }

    /**
     * Menampilkan daftar semua pesanan masuk (pending dan diproses).
     */
    public function pesananMasuk()
    {
        // Memastikan hanya pengguna dengan peran 'petugas' yang bisa mengakses
        if (Auth::user()->role !== 'petugas') {
            abort(403, 'Akses hanya untuk petugas.');
        }

        // Ambil semua pesanan yang statusnya 'pending' atau 'diproses'
        $orders = Pesanan::with(['user', 'paket']) 
                           ->whereIn('status', [Pesanan::STATUS_PENDING, Pesanan::STATUS_DIKONFIRMASI, Pesanan::STATUS_DIPROSES])
                           ->orderBy('tanggal', 'asc') 
                           ->orderBy('waktu', 'asc')
                           ->paginate(10); 

        return view('petugas.pesanan', compact('orders'));
    }

    public function riwayatPesanan()
    {
        // Memastikan hanya pengguna dengan peran 'petugas' yang bisa mengakses
        if (Auth::user()->role !== 'petugas') {
            abort(403, 'Akses hanya untuk petugas.');
        }

        // Ambil semua pesanan yang statusnya 'selesai' atau 'dibatalkan'
        $historicalOrders = Pesanan::with(['user', 'paket']) 
                                       ->whereIn('status', [Pesanan::STATUS_SELESAI, Pesanan::STATUS_DIBATALKAN])
                                       ->orderBy('updated_at', 'desc') 
                                       ->paginate(10); 

        return view('petugas.riwayat', compact('historicalOrders'));
    }

    // You might need a method to show order details, for the "Detail" button
    public function showOrderDetail($id)
    {
        if (Auth::user()->role !== 'petugas') {
            abort(403, 'Akses hanya untuk petugas.');
        }

        $order = Pesanan::with(['user', 'paket', 'ulasan'])->findOrFail($id);
        return view('petugas.order_detail', compact('order')); 
    }
}