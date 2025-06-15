<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use App\Models\Pesanan; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'konsumen') {
            abort(403, 'Akses ditolak.');
        }

        $ulasan = Ulasan::whereHas('pesanan', function ($q) {
            $q->where('user_id', Auth::id());
        })->latest()->get();

        $userOrders = Pesanan::where('user_id', Auth::id())
                              ->whereDoesntHave('ulasan') 
                              ->get();

        return view('masyarakat.ulasan', compact('ulasan', 'userOrders'));
    }

    public function store(Request $request) 
    {
        if (Auth::user()->role !== 'konsumen') {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'order_id' => 'required|exists:pesanan,id', 
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string', 
        ]);

        
        $order = Pesanan::where('id', $request->order_id)
                        ->where('user_id', Auth::id())
                        ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan atau Anda tidak memiliki akses.');
        }

        if ($order->ulasan()->exists()) {
            return redirect()->back()->with('error', 'Pesanan ini sudah memiliki ulasan.');
        }

        Ulasan::create([
            'user_id' => Auth::id(), 
            'pesanan_id' => $request->order_id, 
            'rating' => $request->rating,
            'komentar' => $request->comment, 
        ]);

        return redirect()->back()->with('success', 'Ulasan berhasil dikirim.');
    }
}