<?php

namespace App\Http\Controllers;

use App\Models\Pesanan; // Pastikan nama model Anda adalah Pesanan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Untuk filter tanggal di dashboard

class PetugasController extends Controller
{
    /**
     * Menampilkan dashboard petugas dengan ringkasan statistik.
     */
    public function dashboard()
    {
        // Memastikan hanya pengguna dengan peran 'petugas' yang bisa mengakses
        if (Auth::user()->role !== 'petugas') {
            abort(403, 'Akses hanya untuk petugas.');
        }

        // Menghitung statistik untuk dashboard
        // Sesuaikan nilai ENUM 'status' dengan skema tabel Anda: 'pending', 'diproses', 'selesai', 'batal'
        $newOrdersCount = Pesanan::where('status', 'pending')->count(); // Pesanan baru (status 'pending')
        $inProgressOrdersCount = Pesanan::where('status', 'diproses')->count(); // Pesanan sedang diproses

        // Pesanan selesai hari ini
        $completedTodayOrdersCount = Pesanan::where('status', 'selesai')
                                            ->whereDate('updated_at', Carbon::today())
                                            ->count();

        // Mengambil beberapa pesanan masuk terbaru untuk ditampilkan di dashboard
        // Eager load relasi 'user' dan 'paketJasa' (sesuai nama relasi di model Pesanan)
        $latestIncomingOrders = Pesanan::with(['user', 'paketJasa']) // Pastikan relasi 'paketJasa' ada di model Pesanan
                                        ->whereIn('status', ['pending', 'diproses']) // Status yang relevan untuk pesanan masuk
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
        // Pastikan nilai 'in' sesuai dengan ENUM di database Anda: 'pending', 'diproses', 'selesai', 'batal'
        $request->validate([
            'status' => 'required|string|in:pending,diproses,selesai,batal'
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
        $orders = Pesanan::with(['user', 'paketJasa']) // Eager load relasi 'user' dan 'paketJasa'
                         ->whereIn('status', ['pending', 'diproses'])
                         ->orderBy('tanggal', 'asc') // Urutkan berdasarkan tanggal & waktu
                         ->orderBy('waktu', 'asc')
                         ->paginate(10); // Gunakan paginasi

        return view('petugas.pesanan', compact('orders'));
    }

    /**
     * Menampilkan riwayat pesanan (yang sudah selesai atau dibatalkan).
     */
    public function riwayatPesanan()
    {
        // Memastikan hanya pengguna dengan peran 'petugas' yang bisa mengakses
        if (Auth::user()->role !== 'petugas') {
            abort(403, 'Akses hanya untuk petugas.');
        }

        // Ambil semua pesanan yang statusnya 'selesai' atau 'batal'
        $historicalOrders = Pesanan::with(['user', 'paketJasa']) // Eager load relasi 'user' dan 'paketJasa'
                                   ->whereIn('status', ['selesai', 'batal'])
                                   ->orderBy('updated_at', 'desc') // Urutkan dari yang terbaru selesai/dibatalkan
                                   ->paginate(10); // Gunakan paginasi

        return view('petugas.riwayat', compact('historicalOrders'));
    }
}