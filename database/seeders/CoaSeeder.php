<?php

namespace Database\Seeders;

use App\Models\Coa;
use Illuminate\Database\Seeder;

class CoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🏦 Aktiva (Kode Header = 1)
        Coa::create(['kode_coa' => '111', 'nama_akun' => 'Kas', 'header_akun' => 1]);
        Coa::create(['kode_coa' => '112', 'nama_akun' => 'Bank', 'header_akun' => 1]);
        Coa::create(['kode_coa' => '113', 'nama_akun' => 'Piutang Usaha', 'header_akun' => 1]);
        Coa::create(['kode_coa' => '114', 'nama_akun' => 'Persediaan Barang Dagang', 'header_akun' => 1]);
        Coa::create(['kode_coa' => '121', 'nama_akun' => 'Perlengkapan', 'header_akun' => 1]);
        Coa::create(['kode_coa' => '122', 'nama_akun' => 'Beban Dibayar Dimuka', 'header_akun' => 1]);

        // 💳 Kewajiban (Kode Header = 2)
        Coa::create(['kode_coa' => '211', 'nama_akun' => 'Utang Usaha', 'header_akun' => 2]);
        Coa::create(['kode_coa' => '212', 'nama_akun' => 'Utang Pajak', 'header_akun' => 2]);
        Coa::create(['kode_coa' => '213', 'nama_akun' => 'Utang Gaji', 'header_akun' => 2]);

        // 💼 Ekuitas (Kode Header = 3)
        Coa::create(['kode_coa' => '311', 'nama_akun' => 'Modal', 'header_akun' => 3]);

        // 💰 Pendapatan (Kode Header = 4)
        Coa::create(['kode_coa' => '411', 'nama_akun' => 'Pendapatan Jasa', 'header_akun' => 4]);
        Coa::create(['kode_coa' => '412', 'nama_akun' => 'Pendapatan Penjualan', 'header_akun' => 4]);

        // 📉 Beban (Kode Header = 5)
        Coa::create(['kode_coa' => '511', 'nama_akun' => 'Beban Gaji', 'header_akun' => 5]);
        Coa::create(['kode_coa' => '512', 'nama_akun' => 'Beban Listrik', 'header_akun' => 5]);
        Coa::create(['kode_coa' => '513', 'nama_akun' => 'Beban Sewa', 'header_akun' => 5]);
        Coa::create(['kode_coa' => '514', 'nama_akun' => 'Beban ATK', 'header_akun' => 5]);
    }
}
