<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Models\Pelanggan;
use App\Models\Obat;
use App\Models\Penjualan;
use App\Models\Transaksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Penjualan (kredit pada header akun 4 = pendapatan)
        $totalPenjualan = Jurnal::whereHas('coa', function ($q) {
            $q->where('header_akun', 4);
        })->sum('kredit');

        // Total Pembelian (debit pada header akun 5 = beban)
        $totalPembelian = Jurnal::whereHas('coa', function ($q) {
            $q->where('header_akun', 5);
        })->sum('debit');

        // Stok Obat Hampir Habis (<10)
        $stokHampirHabis = Obat::where('jmlh_stok', '<', 10)->get();

        // Jumlah Pelanggan Aktif (pernah transaksi dalam 30 hari)
        $pelangganAktif = Pelanggan::whereHas('penjualan', function ($q) {
            $q->where('tgl_jual', '>=', Carbon::now()->subDays(30))
                ->whereHas('detailPenjualan', function ($q) {
                    $q->whereNotNull('total_jual');
                });
        })->count();

        // Pendapatan Bersih
        $pendapatanBersih = $totalPenjualan - $totalPembelian;

        // Data Transaksi Terbaru
        $transaksiTerbaru = Penjualan::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalPenjualan',
            'totalPembelian',
            'stokHampirHabis',
            'pelangganAktif',
            'pendapatanBersih',
            'transaksiTerbaru'
        ));
    }
}
