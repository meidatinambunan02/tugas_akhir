<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    // Menentukan nama tabel yang digunakan oleh model ini
    protected $table = 'penjualan_detail';

    // Menentukan kolom yang dapat diisi secara massal (mass assignment)
    protected $fillable = [
        'penjualan_id', // ID transaksi penjualan
        'obat_id', // ID obat yang dijual
        'jmlh_jual', // Jumlah obat yang dijual
        'harga_satuan', // Harga satuan obat
        'total_jual' // Total harga berdasarkan jumlah jual * harga satuan
    ];

    /**
     * Relasi ke model Penjualan
     * Setiap detail penjualan hanya terkait dengan satu transaksi penjualan (Many-to-One)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class); // Relasi dengan tabel penjualan
    }

    /**
     * Relasi ke model Obat
     * Setiap detail penjualan hanya terkait dengan satu obat (Many-to-One)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function obat()
    {
        return $this->belongsTo(Obat::class); // Relasi dengan tabel obat
    }
}
