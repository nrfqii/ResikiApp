<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PaketJasa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        $paketJasas = \App\Models\PaketJasa::all();
        return view('masyarakat.pesan', compact('paketJasas'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'alamat_lokasi' => 'required|string|max:1000',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu' => 'required|date_format:H:i',
            'paket_id' => 'nullable|integer|exists:paket_jasa,id',
            'custom_request' => 'nullable|string|max:2000|required_if:is_custom_request,1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_custom_request' => 'sometimes|boolean',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ], [
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'image.max' => 'Ukuran gambar maksimal 2MB.'
        ]);

        try {
            DB::beginTransaction();

            // Data dasar pesanan
            $pesananData = [
                'user_id' => Auth::id(),
                'alamat_lokasi' => $validated['alamat_lokasi'],
                'tanggal' => $validated['tanggal'],
                'waktu' => $validated['waktu'],
                'status' => Pesanan::STATUS_PENDING,
                'is_custom_request' => $validated['is_custom_request'] ?? false,
                'created_at' => now(),
                'updated_at' => now(),
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ];

            // Hitung total harga
            $totalHarga = 0;
            if (!empty($validated['paket_id'])) {
                $paket = PaketJasa::findOrFail($validated['paket_id']);
                $pesananData['paket_id'] = $paket->id;
                $pesananData['nama_paket'] = $paket->nama_paket;
                $pesananData['harga_paket'] = $paket->harga;
                $totalHarga = $paket->harga;
            }

            // Jika custom request
            if ($validated['is_custom_request'] ?? false) {
                $pesananData['custom_request'] = $validated['custom_request'];
                if (empty($validated['paket_id'])) {
                    $totalHarga = 0;
                }
            }
            // dd($pesananData);

            $pesananData['total_harga'] = $totalHarga;

            // **UPLOAD GAMBAR KE public/upload/pesanan/**
            if ($request->hasFile('image')) {
                $uploadDir = 'upload/pesanan/';

                // Buat folder jika belum ada
                if (!file_exists(public_path($uploadDir))) {
                    mkdir(public_path($uploadDir), 0755, true);
                }

                $image = $request->file('image');
                $filename = 'pesanan_' . time() . '_' . Str::random(5) . '.' . $image->getClientOriginalExtension();

                // Pindahkan file ke folder public
                $image->move(public_path($uploadDir), $filename);

                // Simpan path ke database (pastikan kolom 'gambar' ada di tabel)
                $pesananData['gambar'] = $uploadDir . $filename;
            }

            // Logging data gambar
            Log::info('Data gambar pesanan:', [
                'gambar' => $pesananData['gambar'] ?? null
            ]);
            $pesanan = Pesanan::create($pesananData);

            DB::commit();

            // **TAMPILKAN PESAN SUKSES + PREVIEW GAMBAR**
            return redirect()
                ->back()
                ->with([
                    'success' => 'Pesanan berhasil dikirim!',
                    'image_path' => $pesanan->gambar // Kirim path gambar ke view
                ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail pesanan berdasarkan ID.
     */
    // public function show($id)
    // {
    //     $pesanan = Pesanan::with(['user', 'paket_jasa', 'petugas', 'ulasan'])
    //         ->where('user_id', Auth::id()) // Pastikan hanya pemilik pesanan yang bisa melihat
    //         ->findOrFail($id);

    //     return view('pesan.show', compact('pesanan'));
    // }

    /**
     * Menampilkan detail pesanan dalam format JSON (misalnya untuk AJAX).
     */
    public function showDetail($id)
    {
        $order = Pesanan::with(['paket_jasa', 'petugas', 'ulasan'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return response()->json([
            'id' => $order->id,
            'layanan' => $order->paketJasa ? $order->paketJasa->nama_paket : ($order->custom_request ?? 'Layanan Kustom'),
            'status' => $order->status,
            'tanggal' => $order->getTanggalFormattedAttribute(),
            'waktu' => $order->getWaktuFormattedAttribute(),
            'alamat_lokasi' => $order->alamat_lokasi,
            'catatan' => $order->custom_request ?? '-',
            'total_harga' => 'Rp ' . number_format($order->total_harga, 0, ',', '.'),
            'gambar' => $order->gambar ? asset($order->gambar) : null,
            'rating' => optional($order->ulasan)->rating,
            'komentar_ulasan' => optional($order->ulasan)->komentar,
            'latitude' => $order->latitude,
            'longitude' => $order->longitude,
            'petugas_lat' => $order->petugas ? $order->petugas->latitude : null,
            'petugas_lng' => $order->petugas ? $order->petugas->longitude : null,
        ]);
    }
    public function getDetailJson($id)
    {
        $user = auth()->user(); // ambil user saat ini (login)

        // Ambil data pesanan beserta relasi user, petugas, dan paket
        $pesanan = Pesanan::with(['user', 'petugas', 'paket_jasa','ulasan']) // pastikan relasi terdefinisi
            ->where('id', $id)
            ->first();

        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        // Opsional: Batasi akses hanya ke pemilik atau petugas terkait
        if ($user->role == 'konsumen' && $pesanan->user_id !== $user->id) {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        // Format tanggal
        $pesanan->tanggal_formatted = \Carbon\Carbon::parse($pesanan->tanggal)->translatedFormat('l, d F Y');

        // Format status label dan warna
        $statusClass = match ($pesanan->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'diproses' => 'bg-blue-100 text-blue-800',
            'selesai' => 'bg-green-100 text-green-800',
            'dibatalkan' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };

        $pesanan->status_label = ucfirst($pesanan->status);
        $pesanan->status_color = $statusClass;

        // Path gambar (kalau ada)
        $pesanan->gambar = $pesanan->gambar ? asset($pesanan->gambar) : null;

        return response()->json($pesanan);
    }


    public function riwayat()
    {
        $pesanan = Pesanan::with(['paket_jasa']) // Eager load relasi paketJasa
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Paginate untuk performa

        return view('pesan.riwayat', compact('pesanan'));
    }
}