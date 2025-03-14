<?php

namespace Database\Seeders;

use App\Models\PenjualanDetail;
use App\Models\Penjualan;
use App\Models\Obat;
use Illuminate\Database\Seeder;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penjualan = Penjualan::first(); // Ambil penjualan yang sudah dibuat
        $obat = Obat::first(); // Ambil obat yang tersedia
        
        if ($penjualan && $obat) {
            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'obat_id' => $obat->id,
                'jmlh_jual' => 5,
                'harga_satuan' => 10000,
                'total_jual' => 50000
            ]);
        }
    }
}
