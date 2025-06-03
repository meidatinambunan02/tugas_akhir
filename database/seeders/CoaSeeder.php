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
        // Kode COA untuk kategori Aktiva
        // Digunakan untuk mencatat aset atau harta yang dimiliki perusahaan/koperasi
        Coa::create(['kode_coa' => '111', 'nama_akun' => 'Kas', 'header_akun' => 1]); // Kas perusahaan
        Coa::create(['kode_coa' => '112', 'nama_akun' => 'Bank', 'header_akun' => 1]); // Saldo di bank
        Coa::create(['kode_coa' => '113', 'nama_akun' => 'Piutang Usaha', 'header_akun' => 1]); // Piutang dari pelanggan
        Coa::create(['kode_coa' => '114', 'nama_akun' => 'Persediaan Barang Dagang', 'header_akun' => 1]); // Stok barang dagangan
        Coa::create(['kode_coa' => '121', 'nama_akun' => 'Perlengkapan', 'header_akun' => 1]); // Perlengkapan kantor
        Coa::create(['kode_coa' => '122', 'nama_akun' => 'Beban Dibayar Dimuka', 'header_akun' => 1]); // Beban yang dibayar lebih awal

        // 💳 Kewajiban (Kode Header = 2)
        // Kode COA untuk kategori Kewajiban
        // Digunakan untuk mencatat utang atau kewajiban yang harus dibayar oleh perusahaan/koperasi
        Coa::create(['kode_coa' => '211', 'nama_akun' => 'Utang Usaha', 'header_akun' => 2]); // Utang kepada pemasok
        Coa::create(['kode_coa' => '212', 'nama_akun' => 'Utang Pajak', 'header_akun' => 2]); // Kewajiban pajak yang belum dibayar
        Coa::create(['kode_coa' => '213', 'nama_akun' => 'Utang Gaji', 'header_akun' => 2]); // Kewajiban pembayaran gaji karyawan

        // 💼 Ekuitas (Kode Header = 3)
        // Kode COA untuk kategori Ekuitas
        // Digunakan untuk mencatat modal atau kekayaan bersih perusahaan/koperasi
        Coa::create(['kode_coa' => '311', 'nama_akun' => 'Modal', 'header_akun' => 3]); // Modal yang dimiliki oleh koperasi

        // 💰 Pendapatan (Kode Header = 4)
        // Kode COA untuk kategori Pendapatan
        // Digunakan untuk mencatat penghasilan atau pemasukan perusahaan/koperasi
        Coa::create(['kode_coa' => '411', 'nama_akun' => 'Pendapatan Jasa', 'header_akun' => 4]); // Pendapatan dari jasa
        Coa::create(['kode_coa' => '412', 'nama_akun' => 'Pendapatan Penjualan', 'header_akun' => 4]); // Pendapatan dari penjualan barang


        // 📉 Beban (Kode Header = 5)
        // Kode COA untuk kategori Beban
        // Digunakan untuk mencatat pengeluaran atau biaya yang dikeluarkan oleh perusahaan/koperasi
        Coa::create(['kode_coa' => '511', 'nama_akun' => 'Beban Gaji', 'header_akun' => 5]); // Beban untuk pembayaran gaji karyawan
        Coa::create(['kode_coa' => '512', 'nama_akun' => 'Beban Listrik', 'header_akun' => 5]); // Beban untuk pembayaran listrik
        Coa::create(['kode_coa' => '513', 'nama_akun' => 'Beban Sewa', 'header_akun' => 5]); // Beban untuk sewa gedung atau kantor
        Coa::create(['kode_coa' => '514', 'nama_akun' => 'Beban ATK', 'header_akun' => 5]); // Beban untuk alat tulis kantor (ATK)
    }
}