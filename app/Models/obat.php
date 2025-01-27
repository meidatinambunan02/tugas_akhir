<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class obat extends Model
{
     /** @use HasFactory<\Database\Factories\obatFactory> */
     use HasFactory;

     protected $table = 'obat';
 
     protected $fillable = [
         'kode_obat', 'nama_obat', 'jmlh_stok', 'harga', 'tgl_beli'
     ];
     
}
