<?php

namespace Database\Seeders;

use App\Models\Penjualan;
use Illuminate\Database\Seeder;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Penjualan::create([
            'pelanggan_id' => 1,
            'tgl_jual' => now(), // Ganti 'tanggal' menjadi 'tgl_jual'
            'no_trans' => 'TRX-001'
        ]);
    }
}
