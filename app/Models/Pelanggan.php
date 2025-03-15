<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang digunakan oleh model ini
    protected $table = 'pelanggan';

    // Menentukan kolom yang dapat diisi secara massal (mass assignment)
    protected $fillable = [
        'kode_pelanggan', // Kode unik untuk setiap pelanggan
        'nama_pelanggan', // Nama lengkap pelanggan
        'email', // Alamat email pelanggan
        'telepon', // Nomor telepon pelanggan
        'alamat', // Alamat pelanggan
        'user_id', // ID user yang mencatat data pelanggan
    ];

    /**
     * Relasi dengan model Penjualan
     * Pelanggan bisa melakukan banyak transaksi penjualan (One-to-Many)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function penjualan()
    {
        return $this->hasMany(Penjualan::class); // Relasi dengan tabel penjualan
    }
}
