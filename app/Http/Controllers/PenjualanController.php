<?php

namespace App\Http\Controllers;

use App\Models\coa;
use App\Models\Jurnal;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Obat;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $obat = Obat::all();
        $pelanggan = Pelanggan::all();

        // Ambil data riwayat transaksi penjualan
        $riwayat = Penjualan::with('detailPenjualan.obat', 'pelanggan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('penjualan.index', compact('obat', 'pelanggan', 'riwayat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tgl_jual' => 'required|date',
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'cart_data' => 'required|json',
        ]);

        $cartItems = json_decode($request->cart_data, true);

        if (empty($cartItems)) {
            return redirect()->route('penjualan.index')->with('error', 'Keranjang tidak boleh kosong');
        }

        DB::beginTransaction();

        try {
            $no_trans = 'TRX-' . now()->format('YmdHis') . '-' . Str::uuid();

            $penjualan = Penjualan::create([
                'no_trans' => $no_trans,
                'tgl_jual' => $request->tgl_jual,
                'pelanggan_id' => $request->pelanggan_id
            ]);

            $totalPenjualan = 0;

            foreach ($cartItems as $item) {
                $obat = Obat::findOrFail($item['id']);

                if ($obat->jmlh_stok < $item['jumlah']) {
                    throw new \Exception("Stok obat {$obat->nama} tidak mencukupi.");
                }

                PenjualanDetail::create([
                    'penjualan_id' => $penjualan->id,
                    'obat_id' => $obat->id,
                    'jmlh_jual' => $item['jumlah'],
                    'harga_satuan' => $item['harga'],
                    'total_jual' => $item['total'],
                ]);

                $totalPenjualan += $item['total'];

                $obat->decrement('jmlh_stok', $item['jumlah']);
            }

            // **Pencatatan Jurnal Otomatis**
            $no_jurnal = 'JRN-' . now()->format('YmdHis') . '-' . Str::uuid();

            // 🔹 **Jurnal untuk PENDAPATAN (Kredit)**
            $coaPendapatan = Coa::where('kode_coa', '411')->first();
            Jurnal::create([
                'no_jurnal' => $no_jurnal,
                'tgl_jurnal' => now(),
                'coa_id' => $coaPendapatan->id,
                'deskripsi' => 'Pendapatan dari Penjualan No. ' . $no_trans,
                'debit' => 0,
                'kredit' => $totalPenjualan
            ]);

            // 🔹 **Jurnal untuk KAS (Debit)**
            $coaKas = coa::where('kode_coa', '111')->first();
            Jurnal::create([
                'no_jurnal' => $no_jurnal,
                'tgl_jurnal' => now(),
                'coa_id' => $coaKas->id,
                'deskripsi' => 'Kas dari Penjualan No. ' . $no_trans,
                'debit' => $totalPenjualan,
                'kredit' => 0
            ]);

            DB::commit();

            return redirect()->route('penjualan.index')->with('success', 'Transaksi penjualan berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('penjualan.index')->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'id_obat' => 'required|exists:obat,id',
            'jmlh_jual' => 'required|numeric|min:1'
        ]);

        $obat = Obat::findOrFail($request->id_obat);

        if ($obat->jmlh_stok < $request->jmlh_jual) {
            return redirect()->route('penjualan.index')->with('error', 'Stok obat tidak mencukupi');
        }

        try {
            DB::beginTransaction();

            // Buat nomor transaksi unik
            $no_trans = 'TRX-' . now()->format('YmdHis') . '-' . uniqid();

            // Simpan data ke tabel `penjualan`
            $penjualan = Penjualan::create([
                'no_trans' => $no_trans,
                'tgl_jual' => now(),
                'pelanggan_id' => 1 // Anggap default pelanggan ID
            ]);

            // Simpan ke tabel `penjualan_detail`
            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'obat_id' => $obat->id,
                'jmlh_jual' => $request->jmlh_jual,
                'harga_satuan' => $obat->harga,
                'total_jual' => $request->jmlh_jual * $obat->harga
            ]);

            // Kurangi stok setelah transaksi berhasil
            $obat->decrement('jmlh_stok', $request->jmlh_jual);

            DB::commit();

            return redirect()->route('penjualan.index')->with('success', 'Obat berhasil ditambahkan ke transaksi');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('penjualan.index')->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }
}
