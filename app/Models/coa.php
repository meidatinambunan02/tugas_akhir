<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coa extends Model
{
    /** @use HasFactory<\Database\Factories\CoaFactory> */
    use HasFactory;

    // Menentukan nama tabel yang digunakan oleh model ini
    protected $table = 'coa';

    // Menentukan kolom yang dapat diisi secara massal (mass assignment)
    protected $fillable = [
        'kode_coa', // Kode akun (contoh: 111 untuk Kas)
        'nama_akun', // Nama akun (contoh: Kas, Bank, dll)
        'header_akun', // Header akun (contoh: 1 = Aktiva, 2 = Kewajiban, dll)
    ];
  
    /**
     * Relasi dengan model Jurnal
     * COA memiliki banyak jurnal (One-to-Many)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jurnal()
    {
        return $this->hasMany(Jurnal::class, 'coa_id'); // Relasi dengan foreign key 'coa_id' di tabel jurnal
    }
};
