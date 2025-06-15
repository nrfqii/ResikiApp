<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketJasa extends Model
{
    protected $table = 'paket_jasa';
    protected $fillable = ['nama_paket', 'deskripsi', 'harga', 'durasi'];
}
