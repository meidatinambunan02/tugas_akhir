<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $pass = "12345678";
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make($pass),
        ]);

        // 🚀 Buat data pelanggan terkait user
        Pelanggan::create([
            'kode_pelanggan' => 'CUST-001',
            'nama_pelanggan' => 'John Doe',
            'email' => 'john.doe@example.com',
            'telepon' => '08123456789',
            'alamat' => 'Jl. Raya No. 1',
            'user_id' => $user->id, // 👈 Hubungkan ke user
        ]);

        Pelanggan::create([
            'kode_pelanggan' => 'CUST-002',
            'nama_pelanggan' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'telepon' => '08234567890',
            'alamat' => 'Jl. Merdeka No. 2',
            'user_id' => $user->id, // 👈 Hubungkan ke user
        ]);

        Pelanggan::create([
            'kode_pelanggan' => 'CUST-003',
            'nama_pelanggan' => 'Michael Johnson',
            'email' => 'michael.j@example.com',
            'telepon' => '08345678901',
            'alamat' => 'Jl. Sudirman No. 3',
            'user_id' => $user->id, // 👈 Hubungkan ke user
        ]);

        $this->call([
            CoaSeeder::class,
        ]);
    }
}
