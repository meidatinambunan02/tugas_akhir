<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    // Menentukan nama tabel yang digunakan oleh model ini
    protected $table = 'jurnal';

    // Menentukan kolom yang dapat diisi secara massal (mass assignment)
    protected $fillable = [
        'no_jurnal', // Nomor jurnal (kode unik untuk setiap entri jurnal)
        'tgl_jurnal', // Tanggal jurnal dicatat
        'coa_id', // ID akun COA yang terkait dengan jurnal ini
        'deskripsi', // Deskripsi transaksi pada jurnal
        'debit', // Jumlah debit dalam transaksi jurnal
        'kredit', // Jumlah kredit dalam transaksi jurnal
        'user_id', // ID user yang mencatat jurnal
    ];

    /**
     * Relasi dengan model Coa
     * Jurnal dimiliki oleh satu akun COA (Many-to-One)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coa()
    {
        return $this->belongsTo(Coa::class); // Relasi dengan foreign key 'coa_id' di tabel jurnal
    }
}
