<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pesanan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pesanan';
    
    protected $fillable = [
        'user_id',
        'petugas_id',
        'paket_id',
        'custom_request',
        'status',
        'alamat_lokasi',
        'tanggal',
        'waktu',
        'catatan',
        'harga_total'
    ];

    protected $dates = ['deleted_at'];

    // Define status constants for better readability and maintainability
    const STATUS_PENDING = 'pending';
    const STATUS_DIKONFIRMASI = 'dikonfirmasi';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SELESAI = 'selesai';
    const STATUS_BATAL = 'batal';
    const STATUS_DIBATALKAN = 'dibatalkan';

    // Status yang dapat ditampilkan
    public static function getStatusLabels()
    {
        return [
            self::STATUS_PENDING => 'Menunggu Konfirmasi',
            self::STATUS_DIKONFIRMASI => 'Dikonfirmasi',
            self::STATUS_DIPROSES => 'Sedang Diproses',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_BATAL => 'Dibatalkan',
            self::STATUS_DIBATALKAN => 'Dibatalkan'
        ];
    }

    // Method untuk mendapatkan label status
    public function getStatusLabelAttribute()
    {
        $labels = self::getStatusLabels();
        return $labels[$this->status] ?? ucfirst($this->status);
    }

    // Method untuk mendapatkan warna badge status
    public function getStatusColorAttribute()
    {
        $colors = [
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_DIKONFIRMASI => 'bg-blue-100 text-blue-800',
            self::STATUS_DIPROSES => 'bg-indigo-100 text-indigo-800',
            self::STATUS_SELESAI => 'bg-green-100 text-green-800',
            self::STATUS_BATAL => 'bg-red-100 text-red-800',
            self::STATUS_DIBATALKAN => 'bg-red-100 text-red-800'
        ];
        
        return $colors[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    // Scope untuk pesanan aktif (tidak dibatalkan)
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', [self::STATUS_BATAL, self::STATUS_DIBATALKAN]);
    }

    // Scope untuk pesanan yang sedang berjalan
    public function scopeInProgress($query)
    {
        return $query->whereIn('status', [self::STATUS_PENDING, self::STATUS_DIKONFIRMASI, self::STATUS_DIPROSES]);
    }

    // Scope untuk pesanan selesai
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_SELESAI);
    }

    // Relasi ke User (Konsumen)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke User (Petugas)
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    // Relasi ke PaketJasa
    public function paketJasa()
    {
        return $this->belongsTo(PaketJasa::class, 'paket_id');
    }

    // Relasi ke Ulasan (satu pesanan bisa memiliki satu ulasan)
    public function ulasan()
    {
        return $this->hasOne(Ulasan::class, 'pesanan_id');
    }

    // Mutator untuk format tanggal
    public function setTanggalAttribute($value)
    {
        $this->attributes['tanggal'] = date('Y-m-d', strtotime($value));
    }

    // Accessor untuk format tanggal
    public function getTanggalFormattedAttribute()
    {
        return \Carbon\Carbon::parse($this->tanggal)->format('d M Y');
    }

    // Method untuk cek apakah bisa diupdate statusnya
    public function canUpdateStatus($newStatus)
    {
        $validTransitions = [
            self::STATUS_PENDING => [self::STATUS_DIKONFIRMASI, self::STATUS_DIBATALKAN],
            self::STATUS_DIKONFIRMASI => [self::STATUS_DIPROSES, self::STATUS_DIBATALKAN],
            self::STATUS_DIPROSES => [self::STATUS_SELESAI, self::STATUS_DIBATALKAN]
        ];

        return in_array($newStatus, $validTransitions[$this->status] ?? []);
    }

    // Method untuk cek apakah pesanan sudah selesai
    public function isCompleted()
    {
        return $this->status === self::STATUS_SELESAI;
    }

    // Method untuk cek apakah pesanan dibatalkan
    public function isCancelled()
    {
        return in_array($this->status, [self::STATUS_BATAL, self::STATUS_DIBATALKAN]);
    }

    // Method untuk cek apakah pesanan masih aktif
    public function isActive()
    {
        return !$this->isCancelled() && !$this->isCompleted();
    }
}