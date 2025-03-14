<?php

namespace Database\Seeders;

use App\Models\Obat;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Obat::create([
            'kode_obat' => 'OBT001',
            'nama_obat' => 'Paracetamol',
            'harga' => 5000,
            'jmlh_stok' => 100,
            'tgl_beli' => now(),
        ]);

        Obat::create([
            'kode_obat' => 'OBT002',
            'nama_obat' => 'Amoxicillin',
            'harga' => 10000,
            'jmlh_stok' => 50,
            'tgl_beli' => now(),
        ]);
    }
}
