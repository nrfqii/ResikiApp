<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'role', 'alamat', 'no_hp'];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'user_id');
    }

    public function pesananDitangani()
    {
        return $this->hasMany(Pesanan::class, 'petugas_id');
    }
}
