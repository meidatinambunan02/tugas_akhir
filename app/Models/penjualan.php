<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';

    protected $fillable = [
        'no_trans',
        'tgl_jual',
        'pelanggan_id',
        'user_id',
    ];

    /**
     * Relasi ke model Pelanggan
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }


    /**
     * Relasi ke detail penjualan
     */
    public function detailPenjualan()
    {
        return $this->hasMany(PenjualanDetail::class);
    }
}
