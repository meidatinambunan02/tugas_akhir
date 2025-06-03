<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    /** @use HasFactory<\Database\Factories\ObatFactory> */
    use HasFactory;

    // Menentukan nama tabel yang digunakan oleh model ini
    protected $table = 'obat';

    // Menentukan kolom yang dapat diisi secara massal (mass assignment)
    protected $fillable = [
        'kode_obat', // Kode unik untuk setiap obat
        'nama_obat', // Nama obat
        'jenis_obat',// Jenis Obat 
        'harga', // Harga obat
        'satuan', // satuan
        'jmlh_stok', // Jumlah stok obat yang tersedia
        'tgl_beli', // Tanggal pembelian obat
        'user_id', // ID user yang mencatat obat
    ];

    /**
     * Relasi dengan model Penjualan
     * Obat bisa muncul dalam banyak transaksi penjualan (One-to-Many)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_obat'); // Relasi dengan foreign key 'id_obat' di tabel penjualan
    }

    /**
     * Relasi dengan model PenjualanDetail
     * Obat bisa muncul dalam banyak detail penjualan (One-to-Many)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function penjualanDetail()
    {
        return $this->hasMany(PenjualanDetail::class); // Relasi dengan tabel penjualan_detail
    }
}
