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

        $latestIncomingOrders = Pesanan::with(['user', 'paket_jasa'])
            ->whereIn('status', [Pesanan::STATUS_PENDING, Pesanan::STATUS_DIKONFIRMASI, Pesanan::STATUS_DIPROSES])
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu', 'asc')
            ->limit(5)
            ->get();

        return view('Petugas.dashboard_petugas', compact(
            'newOrdersCount',
            'inProgressOrdersCount',
            'completedTodayOrdersCount',
            'latestIncomingOrders'
        ));
    }

    // public function updateStatus(Request $request, $id)
    // {
    //     if (Auth::user()->role !== 'petugas') {
    //         return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
    //     }

    //     $pesanan = Pesanan::findOrFail($id);

    //     $request->validate([
    //         'status' => 'required|string|in:pending,dikonfirmasi,diproses,selesai,dibatalkan'
    //     ]);

    //     $pesanan->update([
    //         'status' => $request->status,
    //         'petugas_id' => Auth::id()
    //     ]);

    //     return response()->json(['success' => true, 'message' => 'Status pesanan berhasil diperbarui.']);
    // }

    public function pesananMasuk(Request $request)
    {
        if (Auth::user()->role !== 'petugas') {
            abort(403, 'Akses hanya untuk petugas.');
        }

        $orders = Pesanan::with(['user', 'paket_jasa'])
            ->whereIn('status', [Pesanan::STATUS_PENDING, Pesanan::STATUS_DIKONFIRMASI, Pesanan::STATUS_DIPROSES])
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('id', 'like', '%' . $request->search . '%')
                        ->orWhereHas('user', function ($user) use ($request) {
                            $user->where('name', 'like', '%' . $request->search . '%');
                        })
                        ->orWhereHas('paket_jasa', function ($paket) use ($request) {
                            $paket->where('nama_paket', 'like', '%' . $request->search . '%');
                        });
                });
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->bulan, function ($query) use ($request) {
                $query->whereMonth('tanggal', Carbon::parse($request->bulan)->month)
                    ->whereYear('tanggal', Carbon::parse($request->bulan)->year);
            })
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu', 'asc')
            ->paginate(10);

        return view('Petugas.pesanan', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        if (Auth::user()->role !== 'petugas') {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        $request->validate([
            'status' => 'required|in:pending,dikonfirmasi,diproses,selesai,dibatalkan',
            'catatan' => 'nullable|string|max:255'
        ]);

        try {
            // Muat pesanan dan relasi terkait
            $pesanan = Pesanan::with(['user', 'paket_jasa'])->findOrFail($id);

            // Validasi transisi status yang diizinkan
            $validTransitions = [
                'pending' => ['dikonfirmasi', 'dibatalkan'],
                'dikonfirmasi' => ['diproses', 'dibatalkan'],
                'diproses' => ['selesai', 'dibatalkan']
            ];

            $fromStatus = $pesanan->status;
            $toStatus = $request->status;

            $allowed = $validTransitions[$fromStatus] ?? [];

            if (!in_array($toStatus, $allowed)) {
                return response()->json([
                    'success' => false,
                    'message' => "Transisi status dari '$fromStatus' ke '$toStatus' tidak diizinkan."
                ], 400);
            }

            // Jika status dibatalkan, hapus pesanan
            if ($request->status === 'dibatalkan') {
                \Log::info("Pesanan #{$id} dibatalkan oleh petugas " . Auth::user()->name);

                $pesanan->ulasan()->delete();
                $pesanan->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Pesanan berhasil ditolak dan dihapus dari sistem.'
                ]);
            }

            // DEBUG: Jika dikonfirmasi, log detail pesanan
            if ($request->status === 'dikonfirmasi') {
                \Log::debug("=== DEBUG KONFIRMASI PESANAN ===");
                \Log::debug("ID Pesanan: " . $pesanan->id);
                \Log::debug("Status Sebelumnya: " . $pesanan->status);
                \Log::debug("User Pemesan: " . ($pesanan->user->name ?? 'N/A'));
                \Log::debug("Alamat: " . ($pesanan->alamat_lokasi ?? 'Tidak ada'));
                \Log::debug("Catatan: " . ($pesanan->catatan ?? 'Tidak ada'));
                \Log::debug("Service: " . ($pesanan->paket_jasa->nama_paket ?? $pesanan->custom_request ?? 'Custom kosong'));
            }

            // Update status dan catatan (jika ada)
            $pesanan->update([
                'status' => $request->status,
                'catatan' => $request->filled('catatan') ? $request->catatan : null,
                'updated_at' => now()
            ]);

            $statusMessages = [
                'dikonfirmasi' => 'Pesanan berhasil dikonfirmasi.',
                'diproses' => 'Pesanan berhasil diproses.',
                'selesai' => 'Pesanan berhasil diselesaikan.'
            ];

            return response()->json([
                'success' => true,
                'message' => $statusMessages[$request->status] ?? 'Status pesanan berhasil diperbarui!',
                'order_id' => $id,
                'new_status' => $request->status
            ]);
        } catch (\Exception $e) {
            \Log::error("Error updating order status: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ], 500);
        }
    }


    public function riwayatPesanan(Request $request)
    {
        if (Auth::user()->role !== 'petugas') {
            abort(403, 'Akses hanya untuk petugas.');
        }

        $historicalOrders = Pesanan::with(['user', 'paket_jasa', 'petugas'])
            ->whereIn('status', [Pesanan::STATUS_SELESAI])
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('id', 'like', '%' . $request->search . '%')
                        ->orWhereHas('user', function ($user) use ($request) {
                            $user->where('name', 'like', '%' . $request->search . '%');
                        })
                        ->orWhereHas('paket_jasa', function ($paket) use ($request) {
                            $paket->where('nama_paket', 'like', '%' . $request->search . '%');
                        });
                });
            })
            ->when($request->bulan, function ($query) use ($request) {
                $query->whereMonth('tanggal', Carbon::parse($request->bulan)->month)
                    ->whereYear('tanggal', Carbon::parse($request->bulan)->year);
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('Petugas.riwayat', compact('historicalOrders'));
    }

    // public function showOrderDetail($id)
    // {
    //     if (Auth::user()->role !== 'petugas') {
    //         abort(403, 'Akses hanya untuk petugas.');
    //     }

    //     $order = Pesanan::with(['user', 'paket_jasa', 'ulasan', 'petugas'])
    //         ->findOrFail($id);

    //     return view('Petugas.order_detail', compact('order'));
    // }

    public function getOrderDetailsJson($id)
    {
        if (Auth::user()->role !== 'petugas') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $order = Pesanan::with(['user', 'paket_jasa', 'petugas'])
            ->findOrFail($id);

        return response()->json([
            'id' => $order->id,
            'user' => [
                'name' => $order->user->name ?? null
            ],
            'paket_jasa' => $order->paket_jasa ? [
                'nama_paket' => $order->paket_jasa->nama_paket
            ] : null,
            'custom_request' => $order->custom_request,
            'tanggal_formatted' => \Carbon\Carbon::parse($order->tanggal)->format('d F Y'),
            'waktu' => $order->waktu,
            'alamat_lokasi' => $order->alamat_lokasi,
            'catatan' => $order->catatan,
            'status' => $order->status,
            'status_label' => $order->getStatusLabelAttribute(),
            'status_color' => $order->getStatusColorAttribute(),
            'petugas' => $order->petugas ? [
                'name' => $order->petugas->name
            ] : null
        ]);
    }
}
