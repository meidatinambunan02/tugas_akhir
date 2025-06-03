<?php

namespace App\Http\Controllers;

use App\Models\coa;
use App\Models\Jurnal;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Obat;
//use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    // Menampilkan halaman penjualan
    public function index()
    {
        // Mengambil semua data obat dari database
        $obat = Obat::all();

        // Mengambil semua data pelanggan dari database
        //$pelanggan = Pelanggan::all();

        // Ambil data riwayat transaksi penjualan dengan relasi ke detail penjualan dan pelanggan 
        $riwayat = Penjualan::with('detailPenjualan.obat')
            ->where('user_id', Auth::id()) // 🔥 Filter berdasarkan user yang sedang login
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal transaksi terbaru
            ->get();

        // Kirim data ke view 'penjualan.index'
        return view('penjualan.index', compact('obat', 'riwayat'));
    }

    // Menyimpan data transaksi penjualan
    public function store(Request $request)
    {
        // Validasi input dari request
        $request->validate([
            'tgl_jual' => 'required|date', // Tanggal jual harus berupa tanggal
           // 'pelanggan_id' => 'required|exists:pelanggan,id', // Pelanggan harus terdaftar di tabel `pelanggan`
            'cart_data' => 'required|json', // Data keranjang harus berupa JSON
        ]);

        // Decode data keranjang dari JSON menjadi array
        $cartItems = json_decode($request->cart_data, true);

        if (empty($cartItems)) {
            return redirect()->route('penjualan.index')->with('error', 'Keranjang tidak boleh kosong');
        }

        // Mulai transaksi database untuk memastikan atomicity (semua berhasil atau gagal)
        DB::beginTransaction();

        try {
            // Generate nomor transaksi unik
            $no_trans = 'TRX-' . now()->format('YmdHis') . '-' . Str::uuid();

            // Simpan data transaksi penjualan ke tabel `penjualan`
            $penjualan = Penjualan::create([
                'no_trans' => $no_trans,
                'tgl_jual' => $request->tgl_jual,
               // 'pelanggan_id' => $request->pelanggan_id,
                'user_id' => Auth::id(),
            ]);

            $totalPenjualan = 0; // Untuk menyimpan total penjualan

            // Looping untuk menyimpan detail penjualan
            foreach ($cartItems as $item) {
                // Cari data obat berdasarkan ID
                $obat = Obat::findOrFail($item['id']);

                // Jika stok tidak mencukupi, lempar exception
                if ($obat->jmlh_stok < $item['jumlah']) {
                    throw new \Exception("Stok obat {$obat->nama} tidak mencukupi.");
                }

                // Simpan detail transaksi ke tabel `penjualan_detail`
                PenjualanDetail::create([
                    'penjualan_id' => $penjualan->id,
                    'obat_id' => $obat->id,
                    'jmlh_jual' => $item['jumlah'],
                    'harga_satuan' => $item['harga'],
                    'total_jual' => $item['total'],
                ]);

                // Tambahkan total transaksi
                $totalPenjualan += $item['total'];

                // Kurangi stok obat setelah transaksi berhasil
                $obat->decrement('jmlh_stok', $item['jumlah']);
            }

            // **Pencatatan Jurnal Otomatis**
            $no_jurnal = 'JRN-' . now()->format('YmdHis') . '-' . Str::uuid();

            // 🔹 **Jurnal untuk KAS (Debit)**
            $coaKas = coa::where('kode_coa', '111')->first(); // Kode akun untuk KAS
            Jurnal::create([
                'no_jurnal' => $no_jurnal,
                'tgl_jurnal' => now(),
                'coa_id' => $coaKas->id,
                'deskripsi' => 'Kas dari Penjualan No. ' . $no_trans,
                'debit' => $totalPenjualan,
                'kredit' => 0,
                'user_id' => Auth::id(),
            ]);

            // 🔹 **Jurnal untuk PENDAPATAN (Kredit)**
            $coaPendapatan = Coa::where('kode_coa', '411')->first(); // Kode akun untuk Pendapatan
            Jurnal::create([
                'no_jurnal' => $no_jurnal,
                'tgl_jurnal' => now(),
                'coa_id' => $coaPendapatan->id,
                'deskripsi' => 'Pendapatan dari Penjualan No. ' . $no_trans,
                'debit' => 0,
                'kredit' => $totalPenjualan,
                'user_id' => Auth::id(),
            ]);

            // Commit transaksi jika semua berhasil
            DB::commit();

            return redirect()->route('penjualan.index')->with('success', 'Transaksi penjualan berhasil disimpan');
        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            return redirect()->route('penjualan.index')->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    // Menambahkan obat ke keranjang
    public function addToCart(Request $request)
    {
        // Validasi data input
        $request->validate([
            'id_obat' => 'required|exists:obat,id', // Obat harus terdaftar di tabel `obat`
            'jmlh_jual' => 'required|numeric|min:1' // Jumlah jual harus angka minimal 1
        ]);

        // Cari data obat berdasarkan ID
        $obat = Obat::findOrFail($request->id_obat);

        // Jika stok tidak mencukupi, kembalikan error
        if ($obat->jmlh_stok < $request->jmlh_jual) {
            return redirect()->route('penjualan.index')->with('error', 'Stok obat tidak mencukupi');
        }

        try {
            // Mulai transaksi database
            DB::beginTransaction();

            // Generate nomor transaksi unik
            $no_trans = 'TRX-' . now()->format('YmdHis') . '-' . uniqid();

            // Simpan data penjualan ke tabel `penjualan`
            $penjualan = Penjualan::create([
                'no_trans' => $no_trans,
                'tgl_jual' => now(),
               // 'pelanggan_id' => 1 // Anggap default pelanggan ID
            ]);

            // Simpan detail penjualan ke tabel `penjualan_detail`
            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'obat_id' => $obat->id,
                'jmlh_jual' => $request->jmlh_jual,
                'harga_satuan' => $obat->harga,
                'total_jual' => $request->jmlh_jual * $obat->harga
            ]);

            // Kurangi stok obat setelah transaksi berhasil
            $obat->decrement('jmlh_stok', $request->jmlh_jual);

            // Commit transaksi jika sukses
            DB::commit();

            return redirect()->route('penjualan.index')->with('success', 'Obat berhasil ditambahkan ke transaksi');
        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            return redirect()->route('penjualan.index')->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }
}
