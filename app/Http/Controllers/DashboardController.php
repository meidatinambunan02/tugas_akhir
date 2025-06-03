<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Models\Pelanggan;
use App\Models\Obat;
use App\Models\Penjualan;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Fungsi untuk menampilkan data pada dashboard
    public function index()
    {
        // ✅ Total Penjualan (kredit pada header akun 4 = pendapatan)
        // Mengambil total penjualan berdasarkan jurnal dengan header akun 4 (pendapatan)
        // Filter berdasarkan user yang sedang login
        $totalPenjualan = Jurnal::where('user_id', Auth::id()) 
            ->whereHas('coa', function ($q) {
                $q->where('header_akun', 4);
            })->sum('kredit'); // Menjumlahkan nilai kredit untuk mendapatkan total pendapatan

        // ✅ Total Pembelian (debit pada header akun 5 = beban)
        // Mengambil total pembelian berdasarkan jurnal dengan header akun 5 (beban)
        // Filter berdasarkan user yang sedang login
        $totalPembelian = Jurnal::where('user_id', Auth::id()) 
            ->whereHas('coa', function ($q) {
                $q->where('header_akun', 5);
            })->sum('debit'); // Menjumlahkan nilai debit untuk mendapatkan total beban/pembelian

        // ✅ Total Aset (header akun 1)
        // Menghitung total aset berdasarkan jurnal dengan header akun 1 (aset)
        // Filter berdasarkan user yang sedang login
        $totalAset = Jurnal::where('user_id', Auth::id())
            ->whereHas('coa', function ($q) {
                $q->where('header_akun', 1);
            })
            ->sum('debit'); // Menjumlahkan nilai debit untuk mendapatkan total aset

        // ✅ Stok Obat Hampir Habis (<10)
        // Mengambil daftar obat yang jumlah stoknya kurang dari 10
        // Filter berdasarkan user yang sedang login
        $stokHampirHabis = Obat::where('user_id', Auth::id()) 
            ->where('jmlh_stok', '<', 10)
            ->get(); // Mengambil data obat dengan stok kurang dari 10

        // ✅ Jumlah Pelanggan Aktif (pernah transaksi dalam 30 hari terakhir)
        // Menghitung jumlah pelanggan yang pernah melakukan transaksi dalam 30 hari terakhir
        $pelangganAktif = Pelanggan::count(); // Total semua pelanggan, tanpa melihat aktivitas

    //    $pelangganAktif = Pelanggan::whereHas('penjualan', function ($q) {
            // $q->where('user_id', Auth::id()) // Filter berdasarkan user yang sedang login
             //   ->where('tgl_jual', '>=', Carbon::now()->subDays(30)) // Transaksi dalam 30 hari terakhir
              //  ->whereHas('detailPenjualan', function ($q) {
                //    $q->whereNotNull('total_jual'); // Pastikan transaksi memiliki total jual yang valid
             //   });
      //  })->count(); // Menghitung jumlah pelanggan yang memenuhi kriteria

        // ✅ Pendapatan Bersih
        // Menghitung pendapatan bersih dari total penjualan dikurangi total pembelian
        $pendapatanBersih = $totalPenjualan - $totalPembelian;

        // ✅ Data Transaksi Terbaru
        // Mengambil 5 transaksi penjualan terbaru berdasarkan tanggal transaksi
        $transaksiTerbaru = Penjualan::where('user_id', Auth::id()) 
            ->latest() // Mengurutkan dari transaksi terbaru
            ->take(5) // Mengambil 5 transaksi terbaru
            ->get();

        // ✅ Mengirimkan data ke view `dashboard`
        return view('dashboard', compact(
            'totalPenjualan',    // Total penjualan
            'totalPembelian',    // Total pembelian
            'totalAset',         // Total aset
            'stokHampirHabis',   // Daftar stok obat yang hampir habis
            'pelangganAktif',    // Jumlah pelanggan aktif
            'pendapatanBersih',  // Pendapatan bersih
            'transaksiTerbaru'   // Daftar transaksi terbaru
        ));
    }
}
