<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed database dengan data awal.
     */
    public function run(): void
    {
        // ✅ Buat user dengan data statis
        $pass = "12345678"; // Password untuk user
        $user = User::factory()->create([
            'name' => 'Test User', // Nama user
            'email' => 'test@example.com', // Email user
            'password' => Hash::make($pass), // Hash password untuk keamanan
        ]);

        // ✅ Buat data pelanggan untuk user yang sudah dibuat
        Pelanggan::create([
            'kode_pelanggan' => 'CUST-001', // Kode unik pelanggan
            'nama_pelanggan' => 'John Doe', // Nama pelanggan
            'email' => 'john.doe@example.com', // Email pelanggan
            'telepon' => '08123456789', // Nomor telepon pelanggan
            'alamat' => 'Jl. Raya No. 1', // Alamat pelanggan
            'user_id' => $user->id, // Hubungkan ke user yang sudah dibuat
        ]);

        Pelanggan::create([
            'kode_pelanggan' => 'CUST-002',
            'nama_pelanggan' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'telepon' => '08234567890',
            'alamat' => 'Jl. Merdeka No. 2',
            'user_id' => $user->id,
        ]);

        Pelanggan::create([
            'kode_pelanggan' => 'CUST-003',
            'nama_pelanggan' => 'Michael Johnson',
            'email' => 'michael.j@example.com',
            'telepon' => '08345678901',
            'alamat' => 'Jl. Sudirman No. 3',
            'user_id' => $user->id,
        ]);

        // ✅ Panggil Seeder lain (CoaSeeder)
        $this->call([
            CoaSeeder::class, // Seeder untuk data akun (coa)
        ]);
    }
}
