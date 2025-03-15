<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiLain extends Model
{
    // Menentukan nama tabel yang digunakan oleh model ini
    protected $table = 'transaksi_lain';

    // Menentukan kolom yang dapat diisi secara massal (mass assignment)
    protected $fillable = [
        'no_trans', // Nomor transaksi
        'tgl_trans', // Tanggal transaksi
        'coa_id', // ID akun COA terkait
        'user_id', // ID user yang melakukan transaksi
        'total', // Total nilai transaksi
        'keterangan' // Keterangan atau deskripsi transaksi
    ];

    /**
     * Relasi ke model Jurnal
     * Setiap transaksi lain bisa memiliki banyak jurnal (One-to-Many)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jurnal()
    {
        return $this->hasMany(Jurnal::class, 'no_jurnal', 'no_trans'); // Relasi dengan tabel jurnal berdasarkan nomor transaksi
    }

    /**
     * Relasi ke model Coa
     * Setiap transaksi lain terkait dengan satu akun COA (Many-to-One)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coa()
    {
        return $this->belongsTo(Coa::class); // Relasi dengan tabel coa
    }
}
