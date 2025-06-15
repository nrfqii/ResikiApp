<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'user_id', 
        'petugas_id', 
        'paket_id', 
        'nama_paket',
        'harga_paket',
        'custom_request',
        'status', 
        'alamat_lokasi', 
        'tanggal', 
        'waktu',
        'catatan',
        'total_harga'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu' => 'datetime:H:i',
        'harga_paket' => 'decimal:2',
        'total_harga' => 'decimal:2',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_DIKONFIRMASI = 'dikonfirmasi';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DIBATALKAN = 'dibatalkan';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function paket()
    {
        return $this->belongsTo(PaketJasa::class, 'paket_id');
    }

    public function ulasan()
    {
        return $this->hasOne(Ulasan::class);
    }

    // Scope untuk filter status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Accessor untuk format harga
    public function getFormattedHargaPaketAttribute()
    {
        return $this->harga_paket ? 'Rp ' . number_format($this->harga_paket, 0, ',', '.') : null;
    }

    public function getFormattedTotalHargaAttribute()
    {
        return $this->total_harga ? 'Rp ' . number_format($this->total_harga, 0, ',', '.') : null;
    }
}