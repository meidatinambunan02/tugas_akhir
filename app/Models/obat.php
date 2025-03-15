<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class obat extends Model
{
    /** @use HasFactory<\Database\Factories\obatFactory> */
    use HasFactory;

    protected $table = 'obat';


    protected $fillable = ['kode_obat', 'nama_obat', 'harga', 'jmlh_stok', 'tgl_beli'];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_obat');
    }

    public function penjualanDetail()
    {
        return $this->hasMany(PenjualanDetail::class);
    }
}
