<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penjualan extends Model
{
     /** @use HasFactory<\Database\Factories\obatFactory> */
     use HasFactory;

     protected $table = 'obat';
 
     protected $fillable = [
         'id_jual', 'no_trans', 'tgl_beli', 'nama_obat', 'jmlh_jual', 'harga_satuan', 'total_jual'
     ];
     
}
