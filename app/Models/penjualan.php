<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang digunakan oleh model ini
    protected $table = 'penjualan';

    // Menentukan kolom yang dapat diisi secara massal (mass assignment)
    protected $fillable = [
        'no_trans', // Nomor transaksi penjualan
        'tgl_jual', // Tanggal transaksi penjualan
        'pelanggan_id', // ID pelanggan yang melakukan transaksi
        'user_id', // ID user yang mencatat transaksi
    ];

    /**
     * Relasi ke model Pelanggan
     * Setiap penjualan hanya terkait dengan satu pelanggan (Many-to-One)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class); // Relasi dengan tabel pelanggan
    }

    /**
     * Relasi ke model Obat
     * Setiap penjualan hanya terkait dengan satu jenis obat (Many-to-One)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat'); // Relasi dengan tabel obat
    }

    /**
     * Relasi ke model PenjualanDetail
     * Setiap penjualan bisa memiliki banyak detail penjualan (One-to-Many)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detailPenjualan()
    {
        return $this->hasMany(PenjualanDetail::class); // Relasi dengan tabel detail penjualan
    }
}
