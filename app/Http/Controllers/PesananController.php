<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PaketJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function index()
    {
        return view('masyarakat.pesan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'alamat_lokasi' => 'required|string|max:1000',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu' => 'required',
            'paket_id' => 'nullable|string',
            'custom_request' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'alamat_lokasi.required' => 'Alamat lokasi harus diisi',
            'tanggal.required' => 'Tanggal harus diisi',
            'tanggal.after_or_equal' => 'Tanggal tidak boleh kurang dari hari ini',
            'waktu.required' => 'Waktu harus diisi',
            'image.image' => 'File harus berupa gambar',
            'image.max' => 'Ukuran gambar maksimal 2MB'
        ]);

        try {
            DB::beginTransaction();

            $pesananData = [
                'user_id' => Auth::id(),
                'alamat_lokasi' => $request->alamat_lokasi,
                'tanggal' => $request->tanggal,
                'waktu' => $request->waktu,
                'custom_request' => $request->custom_request,
                'status' => Pesanan::STATUS_PENDING
            ];

            // Jika memilih paket
            if ($request->paket_id) {
                $paket = $this->getPaketBySlug($request->paket_id);
                
                if ($paket) {
                    $pesananData['paket_id'] = $paket['id'] ?? null;
                    $pesananData['nama_paket'] = $paket['nama'];
                    $pesananData['harga_paket'] = $paket['harga'];
                    $pesananData['total_harga'] = $paket['harga'];
                }
            }

            // Handle image upload jika ada
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('pesanan', 'public');
                $pesananData['gambar'] = $imagePath;
            }

            $pesanan = Pesanan::create($pesananData);

            DB::commit();

            return redirect()->back()->with('success', 
                'Pesanan berhasil dikirim! Kami akan menghubungi Anda segera untuk konfirmasi.'
            );

        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()->with('error', 
                'Terjadi kesalahan saat mengirim pesanan. Silakan coba lagi.'
            )->withInput();
        }
    }

    private function getPaketBySlug($slug)
    {
        // Mapping paket berdasarkan slug dari frontend
        $paketMap = [
            'ruangan' => [
                'id' => 1, // Sesuaikan dengan ID di database
                'nama' => 'Bersih Ruangan',
                'harga' => 150000
            ],
            'gudang' => [
                'id' => 2,
                'nama' => 'Bersih Gudang', 
                'harga' => 300000
            ],
            'sapu-pel' => [
                'id' => 3,
                'nama' => 'Sapu & Mengepel',
                'harga' => 75000
            ],
            'cuci-kaca' => [
                'id' => 4,
                'nama' => 'Cuci Kaca & Jendela',
                'harga' => 100000
            ]
        ];

        return $paketMap[$slug] ?? null;
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['user', 'paket', 'petugas'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('pesan.show', compact('pesanan'));
    }

    public function riwayat()
    {
        $pesanan = Pesanan::with(['paket'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pesan.riwayat', compact('pesanan'));
    }
}