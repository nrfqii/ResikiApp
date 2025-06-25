<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon; // Pastikan Carbon diimpor

class Pesanan extends Model
{
    use HasFactory, SoftDeletes;

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
            'total_harga',          
            'gambar',
            'latitude',
            'longitude'
                            
        ];

    protected $dates = ['deleted_at']; 

    const STATUS_PENDING = 'pending';
    const STATUS_DIKONFIRMASI = 'dikonfirmasi';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SELESAI = 'selesai';
    const STATUS_BATAL = 'batal'; 
    const STATUS_DIBATALKAN = 'dibatalkan';

    
    public static function getStatusLabels(): array
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

    /**
     * Accessor untuk mendapatkan label status pesanan.
     */
    public function getStatusLabelAttribute(): string
    {
        $labels = self::getStatusLabels();
        return $labels[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Accessor untuk mendapatkan warna badge status pesanan (untuk tampilan UI).
     */
    public function getStatusColorAttribute(): string
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

    /**
     * Scope query untuk mendapatkan pesanan aktif (tidak dibatalkan atau selesai).
     */
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', [self::STATUS_BATAL, self::STATUS_DIBATALKAN, self::STATUS_SELESAI]);
    }

    /**
     * Scope query untuk mendapatkan pesanan yang sedang berjalan.
     */
    public function scopeInProgress($query)
    {
        return $query->whereIn('status', [self::STATUS_PENDING, self::STATUS_DIKONFIRMASI, self::STATUS_DIPROSES]);
    }

    /**
     * Scope query untuk mendapatkan pesanan yang sudah selesai.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_SELESAI);
    }

    /*
    |--------------------------------------------------------------------------
    | Relasi Model
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi dengan model User (untuk Konsumen yang membuat pesanan).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi dengan model User (untuk Petugas yang ditugaskan).
     */
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    /**
     * Relasi dengan model PaketJasa (layanan yang dipesan).
     */
    public function paket_jasa()
    {
        return $this->belongsTo(PaketJasa::class, 'paket_id');
    }
    

    /**
     * Relasi dengan model Ulasan (satu pesanan bisa memiliki satu ulasan).
     */
    public function ulasan()
    {
        return $this->hasOne(Ulasan::class, 'pesanan_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Mutator & Accessor
    |--------------------------------------------------------------------------
    */

    /**
     * Mutator untuk memastikan format tanggal sebelum disimpan ke DB.
     */
    public function setTanggalAttribute($value)
    {
        $this->attributes['tanggal'] = Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * Accessor untuk mendapatkan tanggal dalam format 'd F Y'.
     */
    public function getTanggalFormattedAttribute(): string
    {
        return Carbon::parse($this->tanggal)->translatedFormat('d F Y');
    }

    /**
     * Accessor untuk mendapatkan waktu dalam format 'HH:MM'.
     */
    public function getWaktuFormattedAttribute(): string
    {
        return Carbon::parse($this->waktu)->format('H:i');
    }

    /*
    |--------------------------------------------------------------------------
    | Metode Bisnis Logika
    |--------------------------------------------------------------------------
    */

    /**
     * Mengecek apakah status pesanan bisa diupdate ke status baru.
     */
    public function canUpdateStatus(string $newStatus): bool
    {
        $validTransitions = [
            self::STATUS_PENDING => [self::STATUS_DIKONFIRMASI, self::STATUS_DIBATALKAN],
            self::STATUS_DIKONFIRMASI => [self::STATUS_DIPROSES, self::STATUS_DIBATALKAN],
            self::STATUS_DIPROSES => [self::STATUS_SELESAI, self::STATUS_DIBATALKAN]
        ];

        return in_array($newStatus, $validTransitions[$this->status] ?? []);
    }

    /**
     * Mengecek apakah pesanan sudah selesai.
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_SELESAI;
    }

    /**
     * Mengecek apakah pesanan dibatalkan.
     */
    public function isCancelled(): bool
    {
        return in_array($this->status, [self::STATUS_BATAL, self::STATUS_DIBATALKAN]);
    }

    /**
     * Mengecek apakah pesanan masih aktif (belum selesai atau dibatalkan).
     */
    public function isActive(): bool
    {
        return !$this->isCancelled() && !$this->isCompleted();
    }
}