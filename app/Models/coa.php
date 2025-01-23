<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class coa extends Model
{
    /** @use HasFactory<\Database\Factories\CoaFactory> */
    use HasFactory;

    protected $table = 'coa';

    protected $fillable = [
        'kode_coa', 'nama_akun', 'header_akun',
    ];
    
};
