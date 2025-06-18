<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PaketJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PesananController extends Controller
{
    public function index()
    {
        $paketJasas = \App\Models\PaketJasa::all();
        return view('masyarakat.pesan', compact('paketJasas'));
    }

    public function store(Request $request)
{
    // Validasi input dari form
    $validated = $request->validate([
        'alamat_lokasi' => 'required|string|max:1000',
        'tanggal' => 'required|date|after_or_equal:today',
        'waktu' => 'required|date_format:H:i',
        'paket_id' => 'nullable|integer|exists:paket_jasa,id',
        'custom_request' => 'nullable|string|max:2000|required_if:is_custom_request,1', 
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'is_custom_request' => 'sometimes|boolean'
    ], [
        'alamat_lokasi.required' => 'Alamat lokasi harus diisi.',
        'tanggal.required' => 'Tanggal harus diisi.',
        'tanggal.after_or_equal' => 'Tanggal tidak boleh kurang dari hari ini.',
        'waktu.required' => 'Waktu harus diisi.',
        'waktu.date_format' => 'Format waktu tidak valid (contoh: 14:30).',
        'paket_id.integer' => 'Pilihan layanan tidak valid.',
        'paket_id.exists' => 'Layanan yang dipilih tidak ditemukan.',
        'custom_request.required_if' => 'Detail permintaan kustom harus diisi ketika memilih permintaan khusus.',
        'custom_request.string' => 'Detail permintaan kustom harus berupa teks.',
        'custom_request.max' => 'Detail permintaan kustom maksimal 2000 karakter.',
        'image.image' => 'File harus berupa gambar.',
        'image.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau svg.',
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
            'updated_at' => now()
        ];

        $totalHarga = 0;

        // Jika ada paket yang dipilih
        if (!empty($validated['paket_id'])) {
            $paket = PaketJasa::findOrFail($validated['paket_id']);
            $pesananData['paket_id'] = $paket->id;
            $pesananData['nama_paket'] = $paket->nama_paket;
            $pesananData['harga_paket'] = $paket->harga;
            $totalHarga = $paket->harga;
        }

        // Jika custom request dicentang
        if ($validated['is_custom_request'] ?? false) {
            $pesananData['custom_request'] = $validated['custom_request'] ?? null;
            
            // Jika tidak ada paket yang dipilih, set harga awal ke 0 (akan ditentukan admin)
            if (empty($validated['paket_id'])) {
                $totalHarga = 0;
            }
        }

        $pesananData['total_harga'] = $totalHarga;

        // Handle upload gambar dengan lebih robust
        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                $imageName = time().'_'.Str::slug($image->getClientOriginalName());
                $path = $image->storeAs('pesanan', $imageName, 'public');
                
                $pesananData['gambar'] = $path;
                
                Log::info('Image stored:', [
                    'path' => $path,
                    'full_path' => storage_path('app/public/'.$path)
                ]);
            } catch (\Exception $e) {
                Log::error('Image upload failed:', ['error' => $e->getMessage()]);
                throw new \Exception('Gagal mengupload gambar: '.$e->getMessage());
            }
        }

        // Buat pesanan
        $pesanan = Pesanan::create($pesananData);
        
        // Log data yang disimpan
        Log::info('Pesanan berhasil dibuat', [
            'pesanan_id' => $pesanan->id,
            'user_id' => Auth::id(),
            'with_image' => isset($pesananData['gambar'])
        ]);

        DB::commit();

        return redirect()
            ->back()
            ->with('success', 'Pesanan berhasil dikirim! Kami akan menghubungi Anda segera untuk konfirmasi.')
            ->with('order_id', $pesanan->id);

    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Gagal menyimpan pesanan', [
            'user_id' => Auth::id(), 
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'request_data' => $request->except(['image']) 
        ]);
        
        $errorMessage = 'Terjadi kesalahan saat mengirim pesanan.';
        if (strpos($e->getMessage(), 'upload') !== false) {
            $errorMessage = 'Gagal mengupload gambar: '.$e->getMessage();
        }
        
        return redirect()
            ->back()
            ->with('error', $errorMessage)
            ->withInput($request->except(['image', '_token']));
    }
}

    /**
     * Menampilkan detail pesanan berdasarkan ID.
     */
    public function show($id)
    {
        $pesanan = Pesanan::with(['user', 'paketJasa', 'petugas', 'ulasan'])
            ->where('user_id', Auth::id()) // Pastikan hanya pemilik pesanan yang bisa melihat
            ->findOrFail($id);

        return view('pesan.show', compact('pesanan'));
    }

    /**
     * Menampilkan detail pesanan dalam format JSON (misalnya untuk AJAX).
     */
    public function showDetail($id)
    {
        $order = Pesanan::with(['paketJasa', 'petugas', 'ulasan'])
            ->where('user_id', auth()->id()) // Pastikan hanya pemilik pesanan yang bisa melihat
            ->findOrFail($id);

        return response()->json([
            'id' => $order->id,
            'layanan' => $order->paketJasa ? $order->paketJasa->nama_paket : ($order->custom_request ?? 'Layanan Kustom'),
            'status' => $order->getStatusLabelAttribute(),
            'tanggal' => $order->getTanggalFormattedAttribute(),
            'waktu' => $order->getWaktuFormattedAttribute(),
            'alamat_lokasi' => $order->alamat_lokasi,
            'catatan' => $order->custom_request ?? '-', // Menampilkan custom_request
            'total_harga' => 'Rp ' . number_format($order->total_harga, 0, ',', '.'),
            // 'petugas' => $order->petugas ? $order->petugas->name : 'Belum ditugaskan',
            'rating' => $order->ulasan ? $order->ulasan->rating : null,
            'komentar_ulasan' => $order->ulasan ? $order->ulasan->komentar : null,
            'gambar_url' => $order->gambar ? asset('storage/' . $order->gambar) : null, // URL gambar
        ]);
    }


    public function riwayat()
    {
        $pesanan = Pesanan::with(['paketJasa']) // Eager load relasi paketJasa
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Paginate untuk performa

        return view('pesan.riwayat', compact('pesanan'));
    }
}