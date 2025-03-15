<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Http\Controllers\ObatController;
use Illuminate\Support\Facades\App;

class ObatSeeder extends Seeder
{
    /**
     * Jalankan database seeder.
     */
    public function run(): void
    {
        $controller = App::make(ObatController::class);

        // ✅ Panggil store() di controller dengan data Paracetamol
        $controller->store(request()->merge([
            'kode_obat' => 'OBT001',
            'nama_obat' => 'Paracetamol',
            'harga' => 5000,
            'jmlh_stok' => 100,
            'tgl_beli' => now()->toDateString(),
        ]));

        // ✅ Panggil store() di controller dengan data Amoxicillin
        $controller->store(request()->merge([
            'kode_obat' => 'OBT002',
            'nama_obat' => 'Amoxicillin',
            'harga' => 10000,
            'jmlh_stok' => 50,
            'tgl_beli' => now()->toDateString(),
        ]));
    }
}
