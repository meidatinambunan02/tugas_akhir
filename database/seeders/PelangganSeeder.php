<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelanggan::create([
            'kode_pelanggan' => 'CUST-001',
            'nama_pelanggan' => 'John Doe', // Ubah dari 'nama' ke 'nama_pelanggan'
            'email' => 'john.doe@example.com',
            'telepon' => '08123456789',
            'alamat' => 'Jl. Raya No. 1'
        ]);
    }
}
